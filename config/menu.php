<?php

use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;

    /*
     *  Example Menu
     */


    Menu::macro('adminlteMenu', function () {
        return Menu::new()
            ->addClass('sidebar-menu tree')
            ->setAttributes(['data-widget=tree']);
    });
    
    Menu::macro('adminlteSubmenu', function ($submenuName) {
        return Menu::new()->prepend('<a href="#"><span> ' . $submenuName . '</span> <i class="fa fa-angle-left pull-right"></i></a>')
            ->addParentClass('treeview')->addClass('treeview-menu');
    });

    Menu::macro('adminlteSeparator', function ($title) {
        return Html::raw($title)->addParentClass('header');
    });
  
    Menu::macro('sidebar', function ($role) {

        if($role == 'superadministrador'){ 
        return Menu::adminlteMenu()
            ->add(Menu::adminlteSeparator('CONFIGURACIÓN'))
                ->add(Link::toUrl('/users', '<i class="fa fa-user"></i><span>Usuarios</span>'))
         
            #adminlte_menu
            ->add(Menu::adminlteSeparator('Administración')) 
                ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-home"></i><span>Administración</span> <i class="fa fa-angle-left pull-right"></i></a>')
                    ->addParentClass('treeview')              
                    ->add(Link::toUrl('/brothers', '<i class="fa fa-circle-o"></i><span>Hermanos</span>'))->addClass('treeview-menu')
                    ->add(Link::toUrl('adminlte', '<i class="fa fa-circle-o"></i><span>Familias</span>'))
                )
    
            ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-usd"></i><span>Finanzas</span> <i class="fa fa-angle-left pull-right"></i></a>')
                ->addParentClass('treeview')        
                    ->add(Link::toUrl('info', '<i class="fa fa-circle-o"></i><span>Ingresos</span>'))->addClass('treeview-menu')
                    ->add(Link::toUrl('adminlte', '<i class="fa fa-circle-o"></i><span>Egresos</span>'))
                    ->add(Link::toUrl('calendar', '<i class="fa fa-circle-o"></i><span>Reportes</span>'))
            )
            ->setActiveFromRequest();
        }
    });


    /*

    Menu::macro('sidebar', function () {
        return Menu::adminlteMenu()
            ->add(Menu::adminlteSeparator('CONFIGURACIÓN'))
                ->action('HomeController@test', '<i class="fa fa-home"></i><span>Home</span>')
                ->add(Link::toUrl('/test', '<i class="fa fa-user-md"></i><span>Test</span>'))
                ->link('http://www.acacha.org', 'Acacha')
                ->url('http://www.google.com', 'Google')
            
            #adminlte_menu
            ->add(Menu::adminlteSeparator('Finanzas'))            
                ->add(Link::toUrl('info', '<i class="fa fa-link"></i><span>Ingresos</span>'))
                ->add(Link::toUrl('adminlte', '<i class="fa fa-link"></i><span>Egresos</span>'))
                ->add(Link::toUrl('calendar', '<i class="fa fa-link"></i><span>Reportes</span>'))
            
            #secondary_menu
            ->add(Menu::adminlteSeparator('SECONDARY MENU'))
                ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-share"></i><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>')
                    ->addParentClass('treeview')
                        ->add(Link::toUrl('/box', '<i class="fa fa-circle-o"></i>Ingresos'))->addClass('treeview-menu')
                        ->add(Link::to('/link1', 'Link1'))->addClass('treeview-menu')
                        ->add(Link::to('/link2', 'Link2'))
                        ->url('http://www.google.com', 'Google')
                        ->add(Menu::new()->prepend('<a href="#"><span>Multilevel 2</span> <i class="fa fa-angle-left pull-right"></i></a>')
                            ->addParentClass('treeview')
                                ->add(Link::to('/link21', 'Link21'))->addClass('treeview-menu')
                                ->add(Link::to('/link22', 'Link22'))
                                ->url('http://www.google.com', 'Google')
                        )
                )
                ->add(Menu::adminlteSubmenu('Best menu')
                    ->add(Link::to('/acacha', 'acacha'))
                    ->add(Link::to('/profile', 'Profile'))
                    ->url('http://www.google.com', 'Google')
                )
            ->setActiveFromRequest();
    });
     */