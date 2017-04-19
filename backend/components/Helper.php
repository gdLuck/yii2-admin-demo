<?php
/**
 * 常用功能
 */
namespace backend\components;


class Helper
{
    /**
     * 后台侧边栏导航菜单回调处理
     * @param unknown $menu
     * @return [
     *        'label' => $menu['name'],
     *        'url' => [$menu['route']],
     *        'options' => $data,
     *        'items' => $menu['children']
     * ]
     */
    public static function sidebarMenuCallback($menu){
        $data = json_decode($menu['data'], true);
        $items = $menu['children'];
        $return = [
            'label' => $menu['name'],
            'url' => [$menu['route']],
        ];
        //处理我们的配置
        if ($data) {
            //visible
            isset($data['visible']) && $return['visible'] = $data['visible'];
            //icon
            isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
            //other attribute e.g. class...
            $return['options'] = $data;
        }
        //没配置图标的显示默认图标
        (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
        $items && $return['items'] = $items;
        return $return;
    }
    
    
}