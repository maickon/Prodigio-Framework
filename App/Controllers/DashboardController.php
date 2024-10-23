<?php

namespace App\Controllers;

use core\Controller;
use core\TemplateTags;
use core\Request;
use core\Router;
use App\Models\Dashboard;

class DashboardController extends Controller {

	public function index() {
		$dashboard = new Dashboard();
		$ordersByWeek = $dashboard->getOrdersFromLastWeek();
		$ordersTotal = $dashboard->getTotalOrders();
		$clientsTotal = $dashboard->getTotalClients();
		$topClient = $dashboard->getClientsByOrderFrequency();
		$totalOrders = $dashboard->getTotalOrdersSummary();
		
		$badClient = end($topClient);
		$topClient = $topClient[0];

		$this->view('dashboard', [
			'title' => 'Dashboard',
			'ordersByWeek' => $ordersByWeek->total_week,
			'ordersTotal' => $ordersTotal->total_orders,
			'clientsTotal' => $clientsTotal->total_clients,
			'topClient' => $topClient,
			'badClient' => $badClient,
			'totalOrders' => $totalOrders,
			'breadcrumb' => [
                'Home' => '/dashboard/administradores',
                'Informações gerais' => '#'
            ]
		]);	
	}

	public function login() {
		$this->view('login');	
	}

	public function recover() {
		$this->view('login/recover', [
		]);	
	}

	public function register() {
		$this->view('login/register', [
		]);	
	}
}