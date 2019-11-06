# phpBB 3.2 TencentCOS Extension
 phpBB 3.2 腾讯 对象存储 COS 扩展

## Description

An extension for [phpBB 3.2](https://www.phpbb.com) that utilizes TencentCOS as the filesystem for uploaded files.  
这是 phpbb 的 腾讯 对象存储 COS 扩展, 允许你使用COS来存放你的网站的文件，并替换掉文章中的所有附件链接, 所以每一个附件都会直接从COS而不是你的服务器下载。减轻了你的服务器的带宽负载。  

The latest version 1.0.6 ( that is, the current version ) can already guarantee that the downloaded file has a normal suffix and file name, and will also delete the thumbnail image when deleting the original image. Add the function of error output to the error log of ACP panel. Add the option of automatically uploading attachments to the bucket.
最新版1.0.6（也就是现在这个版本）已经可以保证下载下来的文件有正常后缀名和文件名了，而且也会在删除原图的时候把删除缩略图删掉。增加错误输出到acp面板的错误日志的功能。增加自动上传附件到存储桶的选项。
 
However, to use the latest version, you need to modify a little bit of phpbb source code yourself. Modify the following two sentences in the /phpbb/attachment/delete.PHP file under the root directory of phpbb:  
但是要使用最新版，你需要自己修改一点点phpbb的源代码。修改phpbb的根目录下的 /phpbb/attachement/delete.php 文件中的以下两句：  

大约274行
```大约274行 原
    $sql = 'SELECT post_msg_id, topic_id, in_message, physical_filename, thumbnail, filesize, is_orphan
    FROM ' . ATTACHMENTS_TABLE . '
    WHERE ' . $this->db->sql_in_set($this->sql_id, $this->ids);
```
   改成：
```大约274行 改
    $sql = 'SELECT post_msg_id, topic_id, in_message, physical_filename, thumbnail, filesize, is_orphan, real_filename
    FROM ' . ATTACHMENTS_TABLE . '
    WHERE ' . $this->db->sql_in_set($this->sql_id, $this->ids);
```
大约298行
```大约278行 改
     $this->physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize'], 'is_orphan' => $row['is_orphan']);
```
   改成：
```大约298行 改
     $this->physical[] = array('filename' => $row['physical_filename'], 'thumbnail' => $row['thumbnail'], 'filesize' => $row['filesize'], 'is_orphan' => $row['is_orphan'], 'real_filename' => $row['real_filename']);
```

## About the Tencent (Cloud Object Storage,COS)

Help documentation is here :  https://cloud.tencent.com/product/cos/document  
帮助文档：https://cloud.tencent.com/product/cos/document

## Installation

Clone into phpBB/ext/AustinMaddox/tencentcos:

    git clone https://github.com/hellohappy0/phpbb-extension-tencentcos phpBB/ext/AustinMaddox/tencentcos

Set up the dependencies:

    php composer.phar install --dev

Go to "ACP" > "Customise" > "Extensions" and enable the "TencentCOS" extension.

## Live Installation

If you want to install the extension in a live board, please only use official releases.
Note that GitHub releases are **NOT** the releases you are looking for.  
You can download from the https://www.phpbb.com or https://www.postgraduate.top ,which can be installed as other general extensions.  
如果你想要直接安装这个扩展，请不要直接下载github版本，他需要使用composer来安装相关的文件，也就是下面链接里面的Vendor文件夹里面的内容。  
官方扩展： https://www.phpbb.com 或者作者自己的网站： https://www.postgraduate.top/viewtopic.php?f=8&t=22

## License

[GPLv2](license.txt)
