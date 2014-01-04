<?php
namespace Sora\Controller\Admin\UserAccount;

class Csv extends \Sora\Controller\Base {
    public function download () {
        /*
         * CSVファイルなどをダウンロードさせる場合、
         * 結果が巨大になると容易くメモリ不足になります
         *
         * 注意点は以下の通りです
         * ・Output Buffer(以後OB)を明示的にオフにして逐次書き込み（送信）する
         * （SlimなどのWAFでは、OBが自動的にOnになります）
         * ・DBなどのデータセットからは逐次読み込みする
         *
         * OBをオフにする場合、手動でヘッダー送信などを行う必要があります
         */
        // CSVに出力するカラム
        $cols_str = 'id,login_id,created_at';
        // PDOStatement::fetch()で一行づつ取得するため、PDOでDBを直接操作します。
        $pdo = \Sora\DB\Base::connection()->getPdo();
        $sth = $pdo->prepare("SELECT {$cols_str} FROM user_account");
        $sth->execute();
        // メモリを消費しない為に、OB をオフにする
        ob_end_clean();
        // 以後はslimの機能をつかわず、直接ヘッダや本文を送信します

        // ブラウザに、ダウンロードダイアログを出し、キャッシュさせないヘッダーを送信
        // 注意：OBを使わない場合、header()の前では１文字も出力してはいけません
        $file_name = 'user_account_list.csv';
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=\"{$file_name}\"");
        header("Expires: 0");
        header("Cache-Control: no-store");
        header("Pragma: no-cache");

        // CSVの1行目として、カラム名行を送信
        echo $cols_str;
        // CSVの本文を送信
        // メモリを消費しない為に、一行づつ読み込み出力しています
        while($row = $sth->fetch(\PDO::FETCH_ASSOC)){
            // 行の全セルの「"」をエスケープし、「"」でくくっています
            $row = array_map(function($cell){
                return '"'.preg_replace('/"/', '""', $cell).'"';
            }, $row);
            // エスケープされたセル配列を「,」でつないで送信します
            echo "\n", implode(',', $row);
        }
    }
}
