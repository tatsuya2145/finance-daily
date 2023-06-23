<div class="app" style="background-color: white;">
    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div id="layout-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6  offset-xl-3">
                            <div class="site-title text-center">
                                <h2>My Portfolio</h2>
                                <p class="mb-0">
                                    このポートフォリオは、Codeigniter3で作成し運用していたシステムをまとめたものです。<br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-2 mt-4" style=" height: 400px">
                        <div class="col-md-6 p-4" style="background: honeydew;">
                            <h3>家計簿</h3>
                            <span class="pre">
                                カテゴリ別に収支を管理できるシステムです。

                                ・カテゴリーマスターテーブルのマスタIDとリレーションをとったデータテーブルのデータと合計値の切り替え

                                ・リレーションをとったデータテーブルからカテゴリー全体の総計を計算して表示

                                ・リクエスト先にてフォーム入力値のバリデーション機能を付与した追加・編集・削除

                                ・データの更新日時から直近の更新を可視化
                            </span>
                        </div>
                        <div class="col-md-6 p-4" style="background: honeydew;">
                            <h3>日記</h3>
                            <span class="pre">
                                JavascriptのCKEditorライブラリを用いて日記を書けるシステムです。
                                
                                ・ブラウザセッションを利用したセッション内ユーザーIDにおける抽出データの切り替え(マルチユーザー機能)

                                ・<a href="https://github.com/azuyalabs/yasumi" target="_blank">Yasumiライブラリ</a>を活用し、独自の関数で拡張した休日・祝日の表示

                                ・UUIDを用いたリソースの管理及びデータ値の新規追加・編集の切り替えと入力値のリアルタイム保存

                                ・日付・キーワード・記入済み(ステータス)による複数条件でのデータ検索

                                ・データテーブル内の該当データチェックにおける記入有無の可視化
                            </span>
                        </div>
                        <div class="col-md-6 p-4 align-middle text-center" style="background: honeydew;">
                            <a href="https://tech-roiru.jp.larksuite.com/wiki/RqaXwA56yiYYTbkW650j1Dtgp3b" target="_blank">
                                <button class="btn btn-success text-white rounded-pill">
                                    詳細仕様はこちら<i class="fas fa-arrow-right" style="color: #ffffff;"></i>
                                </button>
                            </a>
                        </div>
                        <div class="col-md-6 p-4 align-middle text-center" style="background: honeydew;">
                            <a href="https://tech-roiru.jp.larksuite.com/wiki/NfQmweN7Jit0VWkTYiBjw85Zp6c" target="_blank">
                                <button class="btn btn-success text-white rounded-pill">
                                    詳細仕様はこちら<i class="fas fa-arrow-right" style="color: #ffffff;"></i>
                                </button>
                            </a>
                        </div>
                        <div class="col-md-12">
                            <span class="pre">
                                ※ログインセッションの有効期限は2時間です。
                                ※毎日0時00分にデータベースのリセット処理を行うCron設定がされています。
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>