<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Aside extends Component
{
    /**
     * Create a new component instance.
     */
    public $routes;
    public function __construct()
    {
        $this->routes = [
            [
                "label" => "Dashboard",
                "icon" => "fas fa-laptop",
                "route_name" => "dashboard",
                "route_active" => "dashboard",
                "is_dropdown"=> false,
                "dropdown"=>[]
            ],
            [
               "label"=> "Data Users",
                "icon"=> "fas fa-users",
                "route_name"=> "users.index",
                "route_active"=> "users.*",
                "is_dropdown"=> false,
                "dropdown"=>[]
            ],
            [
                "label"=> "Master Data",
                "icon"=> "fas fa-database",
                "route_active"=> "master-data.*",
                "route_name"=> 'master-data.',
                "is_dropdown"=> true,
                "dropdown"=>[
            
                
                    [
                            "label"=> "Category",
                            "route_active"=>"master-data.category.*",
                            "route_name"=>"master-data.category.index",
                    ], [
                            "label"=> "Product",
                            "route_active"=>"master-data.product.*",
                            "route_name"=>"master-data.product.index",
                    ],
                 ]
             ],
                
             [
                
                "label"=> "Goods Receipt",
                "icon"=> "fas fa-truck-loading",
                "route_active"=> "goods-receipt.*",
                "route_name"=> 'goods-receipt.index',
                "is_dropdown"=> false,
                
             ],
             [
             "label"=> "Goods Issuance",
                "icon"=> "fas fa-store",
                "route_active"=> "goods-issuance.*",
                "route_name"=> 'goods-issuance.index',
                "is_dropdown"=> false,
             ],
             [
                "label"=> "Report",
                "icon"=> "fas fa-file-invoice",
                "route_active"=> "report.*",
                "is_dropdown"=> true,
                "dropdown"=>[
                        [
                        "label"=> "Goods",
                        "route_active"=> "report.goods-receipt.*",
                        "route_name"=> "report.goods-receipt.report",
                        
                        ],
                        [
                        "label"=> "Transaction",
                        "route_active"=> "report.goods-issuance.*",
                        "route_name"=> "report.goods-issuance.report",
                        
                        ],     
                    ]
             ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.aside');
    }
}
