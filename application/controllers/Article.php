<?php defined('BASEPATH') or exit('no direct script access allowed');

	class Article extends CI_Controller
	{
		public function __Construct()
		{
			parent::__Construct();

				$this->load->model('Article_model');
		}

		public function index()
		{
			$user_data['link_article'] = 'active';
			$this->load->view('article/view',$user_data);
		}

		public function ajax_list()
		{
			$list = $this->Article_model->get_datatables();
			$no = $_POST['start'];
			$data = array();

			foreach($list as $post)
			{
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $post->article_title;
				$row[] = date("d-m-Y H:i:s", strtotime($post->article_publishdate));
				//add html for action
				$row[] = '<a class="btn btn-sm btn-primary" href="'.base_url().'index.php/article/edit/'.$post->article_id.'" title="Edit"><i class="fa fa-edit"></i> Edit</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Remove" onclick="delete_post('."'".$post->article_id."'".')"><i class="fa fa-trash"></i> Remove</a>';

				$data[] = $row;
			}

			$output = array(
						"draw"=>$_POST['draw'],
						"recordsTotal"=> $this->Article_model->count_all(),
						"recordsFiltered"=> $this->Article_model->count_filtered(),
						"data"=> $data
				);

			echo json_encode($output);
		}

		public function add()
		{
			$user_data['link_article'] = 'active';
			$user_data['category'] = $this->Article_model->get_category();
			$this->load->view('article/add',$user_data);
		}

		public function ajax_add()
		{
			$this->_validate();
			
			$data = array(
					'article_title'=>$this->input->post('article_title'),
					'article_teaser'=>$this->input->post('article_teaser'),
					'article_content'=>$this->input->post('article_content'),
					'article_slug'=>str_replace(array(" ",
												"\'", 
												"\"", 
												"&quot;", 
												";",
												",", 
												"-", 
												"!",
												"#",
												"(",
												")",
												"&",
												"*"), '-', $_POST['article_title']), //for article link
					'article_createdate'=>$this->input->post('article_createdate'),
					'article_publishdate'=>$this->input->post('article_publishdate'),
					'article_category_id'=>$this->input->post('article_category_id'),
				);
			
			if(!empty($_FILES['article_image']['name']))
			{
				$upload = $this->_do_upload();
				$data['article_image'] = $upload;

			}else if(empty($_FILES['article_image']['name']))
			{
				$data['article_image'] = 'no_image.png';
			}

			$this->Article_model->save($data);

			echo json_encode(array("status"=>TRUE));
		}

		public function edit($id)
		{	

			$user_data['link_article'] = 'active';
			$user_data['category'] = $this->Article_model->get_category();
			$user_data['get_data'] = $this->Article_model->get_by_id($id);
			$this->load->view('article/edit',$user_data);
		}

		public function ajax_update()
		{
			$this->_validate();

			$data = array(
					'article_title'=>$this->input->post('article_title'),
					'article_teaser'=>$this->input->post('article_teaser'),
					'article_content'=>$this->input->post('article_content'),
					'article_slug'=>str_replace(array(" ",
												"\'", 
												"\"", 
												"&quot;", 
												";",
												",", 
												"-", 
												"!",
												"#",
												"(",
												")",
												"&",
												"*"), '-', $_POST['article_title']), //for article link
					'article_createdate'=>$this->input->post('article_createdate'),
					'article_publishdate'=>$this->input->post('article_publishdate'),
					'article_category_id'=>$this->input->post('article_category_id'),
				);

			if(!empty($_FILES['article_image']['name']))
			{
				$upload = $this->_do_upload();
				$data['article_image'] = $upload;

			}

			$image_value = str_replace(' ', '_', $_FILES['article_image']['name']);
			$update = $this->Article_model->update(array('article_id'=>$this->input->post('article_id')), $data);

			echo json_encode(array(
				'image'=>$image_value,
				'status'=>TRUE));
		}

		public function ajax_delete($id)
		{
			$this->Article_model->delete($id);
			echo json_encode(array('status'=>TRUE));
		}

		private function _do_upload()
		{
			$this->load->library('image_lib');
			$config['upload_path'] = './uploads/article/original/';
			$config['allowed_types'] = 'jpg|png|gif|jpeg';
			$config['max_size'] = 3000;
			$config['max_width'] = 5000;
			$config['max_height'] = 5000;
			$config['remove_spaces'] = TRUE;

			$this->upload->initialize($config);

			if(!$this->upload->do_upload('article_image'))
			{
				$data['inputerror'][] = 'article_image';
	            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
	            $data['status'] = FALSE;
	            echo json_encode($data);
	            exit();
	        }

	        $data_file = $this->upload->data('file_name');
			
			$this->load->library('image_lib',$config);
			
			$configs_thumb['image_library']    = 'gd2';      
	 		$configs_thumb['source_image']     = './uploads/article/original/'.$data_file;      
 			$configs_thumb['new_image']    	 = './uploads/article/thumb/'.$data_file;      
 			$configs_thumb['width'] = "150";      
 			$configs_thumb['height'] = "150";
        	
			$this->image_lib->initialize($configs_thumb);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			$configs_medium['image_library']    = 'gd2';      
	 		$configs_medium['source_image']     = './uploads/article/original/'.$data_file;      
 			$configs_medium['new_image']    	 = './uploads/article/medium/'.$data_file;      
 			$configs_medium['width'] = "320";      
 			$configs_medium['height'] = "280";
        	
			$this->image_lib->initialize($configs_medium);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			return $data_file;

			print_r($data_file);
		}

		private function _validate(){

			$data  = array();
			$data['error_string'] = array();
			$data['inputerror'] = array();
			$data['status'] = TRUE;

			if($this->input->post('article_title') == ''){
				$data['inputerror'][] = 'article_title';
				$data['error_string'][] = 'Title harus diisi';
				$data['status'] = FALSE;
			} 

			if($this->input->post('article_teaser') == ''){
				$data['inputerror'][] = 'article_teaser';
				$data['error_string'][] = 'Teaser Content harus diisi';
				$data['status'] = FALSE;
			} 

			if($this->input->post('article_content') == ''){
				$data['inputerror'][] = 'article_content';
				$data['error_string'][] = 'Content harus diisi';
				$data['status'] = FALSE;
			} 

			if($this->input->post('article_publishdate') == ''){
				$data['inputerror'][] = 'article_publishdate';
				$data['error_string'][] = 'Tanggal harus diisi';
				$data['status'] = FALSE;
			} 

			if($data['status'] === FALSE){
				echo json_encode($data);
				exit();
			}
		}
	}