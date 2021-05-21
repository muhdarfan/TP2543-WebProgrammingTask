<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MyGuestBook extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('myguestbook_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	function index($error = "") {
		$data['title'] = 'MyGuestBook';
		$data['error'] = $error;

		$this->load->view('mainmenu', $data);
	}

	public function view($error = "") {
		$data['result'] = $this->myguestbook_model->read(null, null, null);
		$data['title'] = 'List of All Comments';
		$data['error'] = $error;

		if ($data['result']) {
			$this->load->view('list', $data);
		} else {
			// 2 ways
			// $this->index();
			redirect(base_url() . "/myguestbook/");
		}
	}

	public function create() {
		if ($this->input->post('form-submitted') == "add") {
			$name = $this->input->post("name");
			$email = $this->input->post("email");
			$comment = $this->input->post("comment");

			$this->form_validation->set_rules("name", "Name", "trim|required");
			$this->form_validation->set_rules("email", "Email", "trim|valid_email|required");
			$this->form_validation->set_rules("comment", "Comment", "trim|required");

			if ($this->form_validation->run() == FALSE) {
				$this->load->view('form');
			} else {
				$postdate = date("Y-m-d",time());
				$posttime = date("H:i:s", time());

				$data = array(
					'user'   => $name,
					'email'  => $email,
					'comment' => $comment,
					'postdate' => $postdate,
					'posttime' => $posttime
				);

				$this->myguestbook_model->create($data);
				$this->view();
			}
		}
		else {
			$this->load->view('form');  
		}
	}

	public function edit() {

		if ($this->input->post('form-submitted') == "edit") {
			$id = $this->uri->segment(3);
			$name = $this->input->post("name");
			$email = $this->input->post("email");
			$comment = $this->input->post("comment");

			$this->form_validation->set_rules("name", "Name", "trim|required");
			$this->form_validation->set_rules("email", "Email", "trim|valid_email|required");
			$this->form_validation->set_rules("comment", "Comment", "trim|required");

			if ($this->form_validation->run() == FALSE) {
				$data['result'] = $this->myguestbook_model->read(array('id' => $id), null, null);
				$this->load->view('edit', $data);
			} else {
				$postdate = date("Y-m-d",time());
				$posttime = date("H:i:s", time());

				$data = array(
					'user'   => $name,
					'email'  => $email,
					'comment' => $comment,
					'postdate' => $postdate,
					'posttime' => $posttime
				);

				$this->myguestbook_model->update($id, $data);
				$this->view();
			}
		} else {
			$id = $this->uri->segment(3);
			$data['result'] = $this->myguestbook_model->read(array('id' => $id), null, null);

			if ($data['result']) {
				$this->load->view('edit', $data);
			} else {
				// 2 ways
				// $this->view();
				redirect(base_url()."myguestbook/view");
			}
		}
	}

	public function remove() {	
		$id = $this->uri->segment(3);
		$this->myguestbook_model->delete($id);
		$this->view();
	}
}
?>