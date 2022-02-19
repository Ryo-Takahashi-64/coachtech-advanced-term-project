# coachtech-advanced-term-project
COACHTECH advancedターム　勤怠管理システム「Atte(アット)」

## プロジェクト概要
[COACHTECH](https://coachtech.site/)のadvancedタームにて作成し、

コードをgithub、及びサイトをHEROKUで公開しています。

「Atte」に会員登録を行ったユーザの勤怠管理を行います。

## デモ
![デモ](./image.png)

## 使い方
[Atte](http://warm-gorge-44259.herokuapp.com/)

1. 上記サイトにアクセスします。
2. 会員登録より会員登録を行います。(登録済の場合、ログインページからログインします)
3. ログイン後のページ構成は以下の3つに分かれています。
    * ホーム(打刻ページ)
        * 勤怠の打刻を行います。
        * 日を跨いだ時点で翌日の出勤操作に切り替わります。
        * 休憩は1日に何度も行うことができますが、一覧では1日の勤怠が1行で表示されます。 
    * 日付別勤怠一覧(日付一覧ページ)
        * Atteに登録しているユーザ全員の日付毎の勤怠一覧を表示します。
        * 初期表示は当日の一覧です。
    * 勤怠一覧
        * ログインしたユーザの月毎の勤怠一覧を表示します。
        * 初期表示は当月の一覧です。

## 環境
* Laravel Framework: 8.76.2
* mysql server version: 10.4.20

## 環境構築
### MAMP/XAMPPの場合
#### (Mac)
* MAMPのインストール
　[MAMPのダウンロードページ](https://www.mamp.info/en/downloads/)
* Composer
   [Composerダウンロードページ](https://getcomposer.org/download/)
   * Manual Downloadから2.〇.〇の最新バージョンのリンクをクリックしてダウンロード
   * 下記コマンドを実行

------------------------------------------

 cd Downloads
 
 sudo mv composer.phar /usr/local/bin/composer
 
 chmod a+x /usr/local/bin/composer

------------------------------------------

#### (Windows)
* XAMPPのインストール
　[XAMPPのダウンロードページ](https://www.apachefriends.org/jp/index.html)
* Composerのインストーラをダウンロードしてインストール
　[Composerダウンロードページ](https://getcomposer.org/doc/00-intro.md#installation-windows)
   * 「Installation – WindowsのUsing the Installer」の文章中の「Composer-Setup.exe」からダウンロード

     ※インストール時のPHP設定画面では、XAMPPのインストールフォルダ内「xampp\php\php.exe」を選択する

#### MAMP/XAMPPインストール後
MAMP/XAMPP内のhtdocsフォルダにソースをgit cloneする

### dockerの場合
下記サイトを参考にツールをダウンロードする

[【超入門】20分でLaravel開発環境を爆速構築するDockerハンズオン](https://qiita.com/ucan-lab/items/56c9dc3cf2e6762672f4)

1. リモートリポジトリの作成は行わず、プロジェクト内「00_Document/02_docker環境構築ファイルのサンプル/」を参考にフォルダを作成する
2. 00_Documentフォルダ以外はプロジェクトディレクトリのbackendフォルダにgit cloneする

### AWSの場合
下記サイトを参考にEC2、RDSのセットアップを行う

[EC2・RDSでLaravelの環境構築【PHP・MySQL・Nginx】](https://qiita.com/yuta_sawamura/items/e925ac687eddfef359fa)

### メール認証
メール認証のテストは[mailtrap](https://mailtrap.io/)を使用する

## 文責
* 作成者：高橋諒

