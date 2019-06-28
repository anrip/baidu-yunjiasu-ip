<?php

$bdip = read_ip_list('https://su.baidu.com/helps/index.html#/1/5a4ca79bb34f69327c4b9dc3');
$cfip = read_ip_list('https://www.cloudflare.com/ips-v4');
$list = array_merge($bdip, $cfip);

make_nginx_real_ip_conf($list);

///////////////////////////////////////////////////////////

function make_nginx_real_ip_conf($list) {
    foreach($list as &$ip) {
        $ip = "set_real_ip_from {$ip};";
    }
    $text = implode("\n", $list);
    file_put_contents('./dist/nginx_real_ip.conf', $text);
}

function read_ip_list($site) {
    $html = file_get_contents($site);
    if(!preg_match_all('/\d+\.\d+\.\d+\.\d+\/\d+/', $html, $list)) {
        exit("读取远程数据失败: {$site}\n");
    }
    return sort_ip_list($list[0]);
}

function sort_ip_list($list) {
    $rets = array();
    foreach(array_unique($list) as $val) {
        $ip = ip2long(explode('/', $val)[0]);
        $ip = sprintf('%u', floatval($ip));
        $rets[$ip] = $val;
    }
    ksort($rets);
    return array_values($rets);
}
