<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//状态转换为文字的方法

function status($status)
{
    if ($status == 1) {
        return "<label class='label label-success radius'>正常</label>";
    } else if ($status == 0) {
        return "<label class='label label-danger radius'>待审</label>";
    } else {
        return "<label class='label label-danger radius'>不通过</label>";
    }
}

//判断是否为总店

function checkMain($isMain)
{
    if ($isMain == 1) {
        return "<label class='label label-success radius'>总店</label>";
    } else if ($isMain == 0) {
        return "<label class='label label-primary radius'>分店</label>";
    } else {
        return "<label class='label label-danger radius'>AA</label>";
    }
}

//设置样式的分页方法

function pagination($pageObj)
{
    if (!$pageObj) {
        return null;
    }
    $result = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>" . $pageObj->render() . "</div>";
    return $result;
}

//网络请求的方法: cURL

/**
 * @param $url  请求的url
 * @param $type 请求的方式 0 是get , 1是post
 * @param array $data 请求的数据(post时使用)
 */
function doCurl($url, $type = 0, $data = [])
{
    //初始化curl

    $ch = curl_init();


    //设置相关的参数
    //set option
    //CURLOPT_URL 请求的链接
    curl_setopt($ch, CURLOPT_URL, $url);

    //返回文本格式的json
    //CURLOPT_RETURNTRANSFER 请求的文本以文本流的形式返回
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //CURLOPT_HEADER 是否返回头部信息 , 0 不反回
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //判断请求方式
    if ($type == 1) {

        curl_setopt($ch, CURLOPT_POST, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    //执行请求
    $result = curl_exec($ch);

    //关闭请求
    curl_close($ch);

    return $result;
}

//判断商户注册状态

function bisRegister($status)
{
    if ($status == 1) {
        $str = '审核成功';
    } else if ($status == 0) {
        $str = '正在审核中,稍后平台方会向你发送邮件,请关注邮件';
    } else if ($status == 2) {
        $str = '审核为通过,你提交的材料不符合要求,请重新提交';
    } else {
        $str = '该申请已经被删除';
    }

    return $str;
}

function getCategoryByPath($category_path)
{
    if (empty($category_path)) {
        return '';
    }

    if (preg_match('/,/', $category_path)) {
        //先按照逗号切割字符串
        $tempArray = explode(',', $category_path);

        //'5,10|12'
        $categoryID = $tempArray[0];

        $tempSeString = $tempArray[1];

        $temp_se_arr = explode('|', $tempSeString);

        $allCategories = model('Category')->getAllFirstNormalCategories(intval($categoryID));

        //循环组合形成input标签字符串

        $htmlString = "";

        for ($i = 0; $i < count($allCategories); $i++) {

            $current = $allCategories[$i];

            //判读当前的current的id是否存在temp_se_arr中

            if (in_array($current['id'], $temp_se_arr)) {
                $htmlString .= "<input type='checkbox' value='" . $current['id'] . "' checked>";
                $htmlString .= "<label>" . $current['name'] . "</label>";

            } else {
                $htmlString .= "<input type='checkbox' value='" . $current['id'] . "'>";
                $htmlString .= "<label>" . $current['name'] . "</label>";
            }
        }
        return $htmlString;
    } else {
        $category_ID = intval($category_path);
        return '';
    }
}


function getCityNameByCityId($city_id)
{
    if (empty($city_id)) {
        return '';
    }

    $city = model('City')->get($city_id);

    return $city->name;
}

function getCategoryNameByCategoryId($categoryID){
    if (empty($categoryID)) {
        return '';
    }

    $category = model('Category')->get($categoryID);

    return $category->name;
}




