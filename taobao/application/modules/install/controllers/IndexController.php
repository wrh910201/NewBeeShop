<?php

class Install_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        header('Content-Type:text/html;charset=utf-8');
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        $config = array('host'=>'localhost', 'username'=>'root', 'password'=>'root', 'dbname'=>'newbeeapp');
        $db = Zend_DB::factory('PDO_MYSQL', $config);
        $sql = array();
        //产品
        $sql[] = "create table if not exists `products` (
            `id` serial,
            `product_name` varchar(255) not null,
            `product_sn` varchar(255) primary key,
            `business_id` int unsigned not null default '0',
            `product_price` float not null,
            `market_price` float not null,
            `is_integral` tinyint not null default '0',
            `integral_require` int unsigned not null default '0',
            `integral_give` int unsigned not null default '0',
            `is_exchange` tinyint not null default '0',
            `desc` varchar(255),
            `description` text,
            `product_inventory` int not null default '0',
            `product_img` varchar(255) not null default 'empty.jpg',
            `is_virtual` tinyint not null default '0',
            `add_time` int not null,
            `is_show` tinyint not null default '0',
            `product_type_id` int default '0',
            `brand_id` int default '0',
            `category_id` int not null default '0',
            `last_modify` int not null,
            `discount` int default '100',
            `rank` int default '5',
            `amount` int default '0',
            `is_new` tinyint not null default '0',
            `is_hot` tinyint not null default '0',
            `has_gift` tinyint not null default '0',
            `gift_list` varchar(255) default '',
            `thumb_img` varchar(255) not null default 'empty_thumb.jpg',
            `original_img` varchar(255) not null default 'empty.jpg'
        ) default charset=utf8;";
        //产品类型
        $sql[] = "create table if not exists `product_type` (
            `id` serial primary key,
            `type_name` varchar(255) not null,
            `business_id` int not null default '0'
        ) default charset=utf8;";
        //产品类型属性
        $sql[] = "create table if not exists `ptoduct_attributes` (
            `id` serial primary key,
            `product_type_id` int not null,
            `attr_name` varchar(255) not null,
            `is_required` tinyint not null default '0',
            `index_mode` int not null default '0',
            `attr_mode` int not null default '0',
            `attr_values` varchar(255),
            `is_associate` tinyint not null default '1'
        ) default charset=utf8;";
        //产品－属性映射
        $sql[] = "create table if not exists `product_attr_map` (
            `id` serial primary key,
            `attr_id` int not null,
            `attr_value` varchar(255) not null,
            `product_id` int not null
        ) default charset=utf8;";
        //品牌
        $sql[] = "create table if not exists `brands` (
            `id` serial primary key,
            `brand_name` varchar(255) not null,
            `business_id` int not null default '0',
            `brand_logo` varchar(255) not null default 'default_logo.jpg',
            `url` varchar(255) not null default '#',
            `brand_description` varchar(255)
        ) default charset=utf8;";
        //相册
        $sql[] = "create table if not exists `gallery` (
            `id` serial primary key,
            `thmub_img` varchar(255) not null,
            `original_img` varchar(255) not null,
            `formal_img` varchar(255) not null,
            `product_id` int not null,
            `view_sort` int not null default '50'
        ) default charset=utf8;";
        //产品分类
        $sql[] = "create table if not exists `category` (
            `id` serial primary key,
            `business_id` int not null default '0',
            `cat_name` varchar(255) not null,
            `parent_id` int not null default '0',
            `is_show` tinyint not null default '1',
            `level` int not null default '1',
            `cat_img` varchar(255),
            `filter_price` int not null default '4',
            `path` varchar(255) not null
        ) default charset=utf8;";
        //产品分类筛选条件
        $sql[] = "create table if not exists `category_filter` (
            `id` serial,
            `goods_attr_id` int not null,
            `cat_id` int not null,
            primary key (`goods_attr_id`, `cat_id`)
        ) default charset=utf8;";
        //优惠活动
        $sql[] = "create table if not exists `activity` (
            `id` serial primary key,
            `title` varchar(255) not null,
            `picture` varchar(255) not null,
            `text` text not null,
            `start_time` int not null,
            `end_time` int not null,
            `user_rank` varchar(255) not null default '0',
            `act_range` int not null default '0',
            `act_range_ext` varchar(255),
            `min_amount` float default '0',
            `max_amount` float default '0',
            `act_type` int not null default '0',
            `act_type_ext` varchar(255),
            `gift` varchar(255),
            `sort_order` int not null default '50'
        ) default charset=utf8;";
        //商家
        $sql[] = "create table if not exists `business` (
            `id` serial,
            `business_sn` varchar(255) not null primary key,
            `business_name` varchar(255) not null,
            `appkey` varchar(255) not null,
            `business_address` varchar(255) not null,
            `business_level` varchar(255) not null default '0',
            `purview` varchar(255) not null default 'guest',
            `manager` int not null,
            `lisence_img` varchar(255) not null,
            `private_rsa` varchar(255)
        ) default charset=utf8;";
        //搜索关键词
        $sql[] = "create table if not exists `search_keywords` (
            `id` serial,
            `keyword` varchar(255) not null,
            `count` int not null default '1',
            `last_modify` int not null,
            `search_type` char(7) not null,
            primary key (`keyword`, `search_type`)
        ) default charset=utf8;";
        //会员
        $sql[] = "create table if not exists `users` (
            `id` serial,
            `user_sn` varchar(255) not null primary key,
            `name` varchar(255) not null,
            `sex` char(2) not null,
            `is_normal` tinyint default '1',
            `user_level_id` int not null default '0',
            `password` varchar(255) not null,
            `phone` varchar(255) not null unique,
            `email` varchar(255),
            `address_id` int not null default '0',
            `direct_parent_id` int default '0',
            `integral` int default '0',
            `business_id` int not null,
            `ebag` float default '0',
            `qq` varchar(255),
            `last_ip` varchar(255) not null,
            `last_time` int not null,
            `purview` varchar(255) not null default 'guest'
        ) default charset=utf8;";
        //会员等级
        $sql[] = "create table if not exists `user_level` (
            `id` serial primary key,
            `integral_min` int not null default '0',
            `integral_max` int not null default '0',
            `designation` varchar(255) not null,
            `is_special` tinyint not null default '0'
        ) default charset=utf8;";
        //初始化游客等级
        $sql[] = "insert into `user_level` values (null, 0, 0, '游客', 0)";
        //用户地址
        $sql[] = "create table if not exists `user_address` (
            `id` serial primary key,
            `consignee` varchar(255) not null,
            `country_id` int not null default '1',
            `province_id` int not null,
            `city_id` int not null,
            `district_id` int not null,
            `address` varchar(255) not null,
            `zipcode` varchar(255) not null,
            `telphone` varchar(255) not null,
            `is_default` tinyint not null default '1',
            `user_id` int not null
        ) default charset=utf8;";
        //会话状态
        $sql[] = "create table if not exists `session` (
            `id` serial,
            `appkey` varchar(255) not null,
            `business_id` int not null,
            `user_id` int not null default '0',
            `session_key` varchar(255) not null primary key
        ) default charset=utf8;";

        foreach($sql as $statement)
        {
            echo $statement."<br/>";
            if(!$db->query($statement))
            {
                echo 'some error happended!<br/>';
            }
        }

        echo 'All tables has been created!';
    }
}

