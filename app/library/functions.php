<?php

/**
 * 判断num是否在min ~ max中间, min < num < max
 *
 * @param  number  $num 目标值
 * @param  number  $min 范围最小值
 * @param  number  $max 范围最大值
 *
 * @return boolean
 */
function isMiddle($num, $min, $max)
{
    return ($num > $min && $num < $max);
}

/**
 * 判断num是否在min ~ max之间, min <= num <= max
 *
 * @param  number  $num 目标值
 * @param  number  $min 范围最小值
 * @param  number  $max 范围最大值
 *
 * @return boolean
 */
function isBetween($num, $min, $max)
{
    return ($num >= $min && $num <= $max);
}

/**
 * uuid生成器
 *
 * @return string
 */
function uuid()
{
    // 数据种子
    $seed = mt_rand(0, 2147483647) . '#' . mt_rand(0, 2147483647);

    // 散列种子并转换为字节数组
    $val  = md5($seed, true);
    $byte = array_values(unpack('C16', $val));

    // 从字节数组中提取字节
    $tLo  = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
    $tMi  = ($byte[4] << 8) | $byte[5];
    $tHi  = ($byte[6] << 8) | $byte[7];
    $csLo = $byte[9];
    $csHi = $byte[8] & 0x3f | (1 << 7);

    if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
        $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
        $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
        $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
    }

    // 应用版本号
    $tHi &= 0x0fff;
    $tHi |= (3 << 12);

    // 转换成字符串
    $uuid = sprintf(
        '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
        $tLo,
        $tMi,
        $tHi,
        $csHi,
        $csLo,
        $byte[10],
        $byte[11],
        $byte[12],
        $byte[13],
        $byte[14],
        $byte[15]
    );

    return $uuid;
}
