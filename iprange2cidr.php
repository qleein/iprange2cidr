<?php

function split_iprange($str, &$start, &$end) {
    $re1 = '/^([\d.]+)-([\d.]+)$/';
    $re2 = '/^(\d+)\.(\d+)\.(\d+).(\d+)$/';
    preg_match($re1, $str, $result);

    preg_match($re2, $result[1], $result2);
    $start = ($result2[1]<<24) + ($result2[2]<<16) + ($result2[3]<<8) + ($result2[4]);

    preg_match($re2, $result[2], $result2);
    $end = ($result2[1]<<24) + ($result2[2]<<16) + ($result2[3]<<8) + ($result2[4]);
    return;
}

function tocidr($str, $mask) {
    $res = '';
    $tmp = 0x000000ff;
    for ($x=3; $x>=0; $x--) {
        $t = $str >> ($x * 8);
        if ($x == 0) {
            $res = $res . gmp_strval(gmp_and($tmp, $t));
        } else {
            $res = $res . gmp_strval(gmp_and($tmp, $t)). ".";
        }
    }
    $res = $res . "/" . $mask;
    return $res;
}


function do_conv(&$result, $start, $end, $pos, $masks, $unmasks) {
    if ($start == $end) {
        $result[count($result)] = tocidr(gmp_strval($start), 32);
        return;
    }
    
    $found = false;
    for ($x=$pos-1; $x>=0; $x--) {
        $res1 = gmp_and($start, $masks[$x]);
        $res2 = gmp_and($end, $masks[$x]);
        if ($res1 != $res2) {
            $pos = $x;
            $found = true;
            break;
        }
    }

    assert($found);

    if (gmp_and($start, $masks[$pos]) == $start and gmp_and($end + 1, $unmasks[$pos]) == 0) {
        $result[count($result)] =  tocidr(gmp_strval($start), (31 - $pos));
        return;
    }
    
    $split_point = gmp_or($start, $unmasks[$pos]);
    do_conv($result, $start, $split_point, $pos, $masks, $unmasks);
    do_conv($result, $split_point + 1, $end, $pos, $masks, $unmasks);
    return;
}

function iprange2cidr($str) {
    split_iprange($str, $start, $end);

    $masks = array();
    $unmasks = array();   
    for ($x=31; $x>=0; $x--) {
        $masks[$x] = (1 <<32) - (1<<($x));
        $unmasks[$x] = (1<<$x) - 1;
    } 
    
    $result = array();
    do_conv($result, $start, $end, 32, $masks, $unmasks);
    return $result;
};

var_dump(iprange2cidr("211.1.1.5-211.1.1.23"));
var_dump(iprange2cidr("211.1.1.5-211.1.1.6"));
var_dump(iprange2cidr("1.0.0.0-129.0.0.0"));
?>

