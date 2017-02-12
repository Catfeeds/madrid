<?php
    //这里要判断是否登录，只有登录的人才能调用这个接口
    require __DIR__.'/qiniusdk/autoload.php';
    use Qiniu\Auth;
    use Qiniu\Storage\UploadManager;

    //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, 'http://'.$_SERVER['HTTP_HOST'].'/api/image/qnUpload');
    //设置头文件的信息作为数据流输出
    // curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);

    echo $data;
?>
