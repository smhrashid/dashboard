<?php
$oracon=oci_connect('shamim', 'bj23Hzs', 'PRAGATI');
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
		public function index(){
		$this->home();
		}
		public function home() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('c_home');
			$this->load->view('pay_footer');
		}
		public function relo() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('relo');
			$this->load->view('pay_footer');
		}
		
			public function banners() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('banners', $data);
		}
		
		public function projbus() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_projbus');
			$this->load->view('pay_footer');
		}
		
		public function dpol() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_pol');
			$this->load->view('pay_footer');
		}
		public function dsb() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_sb');
			$this->load->view('pay_footer');
		}
		
		public function grpbus() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_grpbus');
			$this->load->view('pay_footer');
		}
		public function projcom() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_projcom');
			$this->load->view('pay_footer');
		}
		public function codekpi() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_kpi');
			$this->load->view('pay_footer');
		}		
		
		public function projrcd() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_rcd');
			$this->load->view('pay_footer');
		}
		public function devexp() {
			$data['conn']= $GLOBALS['oracon'];
			$this->load->view('pay_header', $data);
			$this->load->view('d_dev_exp');
			$this->load->view('pay_footer');
		}
}