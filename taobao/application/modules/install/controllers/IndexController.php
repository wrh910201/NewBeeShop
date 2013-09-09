<?php

class Install_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $sql = array();
        //产品
        $sql[] = "create table if not exists `products` (
            `id` serial,
            `product_name` varchar(255) not null,
            `product_sn` varchar(255) primary key,
            `business_id` unsignedint not null default '0',
            `product_price` float not null,
            `market_price` float not null,
            `is_integral` tinyint not null default '0',
            `integral_require` unsignedint not null default '0',
            `integral_give` unsignedint not null default '0',
            `is_exchange` tinyint not null default '0',
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
            `has_gift` tinyint not null default '0',
            `gift_list` varchar(255) default '',
            `thumb_img` varchar(255) not null default 'empty_thumb.jpg',
            `original_img` varchar(255) not null default 'empty.jpg'
        )";
        //产品类型
        $sql[] = "create table if not exists `product_type` (
            `id` serial primary key,
            `type_name` varchar(255) not null,
            `business_id` int not null default '0'
        )";
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
        )";
        //产品－属性映射
        $sql[] = "create table if not exists `product_attr_map` (
            `id` serial primary key,
            `attr_id` int not null,
            `attr_value` varchar(255) not null,
            `product_id` int not null
        )";
        //品牌
        $sql[] = "create table if not exists `brands` (
            `id` serial primary key,
            `brand_name` varchar(255) not null,
            `business_id` int not null default '0',
            `brand_logo` varchar(255) not null default 'default_logo.jpg',
            `url` varchar(255) not null default '#',
            `brand_description` varchar(255)
        )";
        //相册
        $sql[] = "create table if not exists `gallery` (
            `id` serial primary key,
            `thmub_img` varchar(255) not null,
            `original_img` varchar(255) not null,
            `formal_img` varchar(255) not null,
            `product_id` int not null,
            `view_sort` int not null default '50'
        )";
        //产品分类
        $sql[] = "create table if not exists `category` (
            `id` serial primary key,
            `business_id` int not null default '0',
            `cat_name` varchar(255) not null,
            `parent_id` int not null default '0',
            `is_show` tinyint not null default '1',
            `level` int not null default '1',
            `cat_img` varchar(255),
            `filter_price` int not null default '4'
        )";
        //产品分类筛选条件
        $sql[] = "create table if not exists `category_filter` (
            `id` serial,
            `goods_attr_id` int not null,
            `cat_id` int not null,
            primary key (`goods_attr_id`, `cat_id`)
        )";
        //搜索关键词
        $sql[] = "create table if not exists `search_keywords` (
            `id` serial,
            `keyword` varchar(255) not null,
            `count` int not null default '1',
            `last_modify` int not null,
            `search_type` varchar(255) not null
        )";
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
        )";
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
        )";
        //会员
        $sql[] = "create table if not exists `users` (
            
        )";
    }


}

