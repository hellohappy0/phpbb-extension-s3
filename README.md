# phpBB 3.2 TencentCOS Extension
 phpBB 3.2 腾讯 对象存储 COS 扩展

## Description

An extension for [phpBB 3.2](https://www.phpbb.com) that utilizes TencentCOS as the filesystem for uploaded files.  
这是 phpbb 的 腾讯 对象存储 COS 扩展, 允许你使用COS来存放你的网站的文件，并替换掉文章中的所有附件链接, 所以每一个附件都会直接从COS而不是你的服务器下载。减轻了你的服务器的带宽负载。

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
But you can download from the https://www.phpbb.com or https://www.postgraduate.top ,which can be installed as other general extensions.


## License

[GPLv2](license.txt)
