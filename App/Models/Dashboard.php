<?php

namespace App\Models;
use core\ActiveRecord;

class Dashboard extends ActiveRecord {

    public function getOrdersFromLastWeek() {
        $sql = "SELECT COUNT(*) as total_week FROM orders WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
        return $this->executeSql($sql);
    }

    public function getTotalOrders() {
        $sql = "SELECT COUNT(*) as total_orders FROM orders";
        return $this->executeSql($sql);
    }

    public function getTotalClients() {
        $sql = "SELECT COUNT(*) as total_clients FROM clients";
        return $this->executeSql($sql);
    }

    public function getClientsByOrderFrequency() {
        $clientsSql = "SELECT id, name FROM clients";
        $clients = $this->executeSql($clientsSql);
        $clientsById = [];
        foreach ($clients as $client) {
            $clientsById[$client->id] = $client->name;
        }
        $ordersSql = "
            SELECT o.client_id, COUNT(o.client_id) as total_orders, SUM(o.price) as total_spent
            FROM orders o
            GROUP BY o.client_id
            ORDER BY total_orders DESC
        ";
        $orderFrequencies = $this->executeSql($ordersSql);
        foreach ($orderFrequencies as &$order) {
            $order->client_name = isset($clientsById[$order->client_id]) ? $clientsById[$order->client_id] : null;
        }

        return $orderFrequencies;
    }

    public function getTotalOrdersSummary() {
        $sql = "
            SELECT COUNT(*) as total_orders, SUM(price) as total_price
            FROM orders
        ";

        $result = $this->executeSql($sql);

        return [
            'total_orders' => $result->total_orders ?? 0,
            'total_price' => number_format($result->total_price, 2, ',', '.') ?? 0
        ];
    }

}