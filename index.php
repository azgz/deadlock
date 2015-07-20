<?php
require_once './conf/config.php';

// SQLを実行し、DBから一覧を取得
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$stmt = $pdo->prepare("SELECT * FROM cheese_news ORDER BY create_date DESC LIMIT 3");
$stmt->execute();
$view = "";
// SQLの結果から、HTMLを生成
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $news_id = $result['news_id'];
    // 特殊文字チェックを追加
    $news_title = htmlspecialchars($result['news_title'], ENT_QUOTES);
    $create_date = htmlspecialchars($result['create_date'], ENT_QUOTES);
    $view .= '<dt class="news-list--date">' . $create_date . '</dt>'
            // 遷移先へのパラメータは""で囲む必要がないため修正
            . '<dd class="news-list--note"><a href=news.php?news_id=' . $news_id . '>' . $news_title .'</a></dd>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>チーズアカデミーTOKYO</title>
    <meta charset="UTF-8">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-2.1.0.min.js"></script>
    <script>
    $(function(){
        $(window).on("ready resize",function(){
        $(".slides").css({"width":1440,
                         "position":"relative",
                          // キーが""で囲まれていなかったため修正
                          "left":-(1440-$(window).width())/2
                         });
        });
    });
    </script>
</head>
<body>

<div class="wrapper">
    <!-- header  -->
    <header id="header">
       <div class="inner clearfix">
        <h1 class="logo"><img src="image/logo-top.png" alt="Cheese Academy Tokyo" /></h1>
        <ul class="note_wrap">
            <li>CHEESE DEVELOPMENT</li>
            <li>GROWTH CHEESE</li>
            <li>CHEESE PERSPECTIVE</li>
            <li>CHEESE GENERATOR</li>
        </ul>
        </div>
    </header>

    <!--　main_visual   -->
    <section id="main_visual" class="slidesWrap">
        <div class="inner">
            <h2 class="catch">授業後払いのチーズ職人養成学校<br />『チーズアカデミーTOKYO』はじまります。</h2>
        </div>
        <div class="slider">
            <ul class="slides clearfix">
                <li><img src="image/photo-mini.png" alt="" /></li>
                <li><img src="image/photo-mini.png" alt="" /></li>
                <li class="center"><img src="image/photo-main.png" alt="" /></li>
                <li><img src="image/photo-mini.png" alt="" /></li>
                <li><img src="image/photo-mini.png" alt="" /></li>
            </ul>
        </div>

        <div class="inner">
            <nav class="global_Nav">
                <ul class="nav_wrap clearfix">
                    <li class="nav_item"><a href="#">HOME<br />-ホーム-</a></li>
                    <li class="nav_item"><a href="#">NEWS<br />-お知らせ・更新情報-</a></li>
                    <li class="nav_item"><a href="#">FEATURE<br />-特徴-</a></li>
                    <li class="nav_item"><a href="#">COURCE<br />-コース紹介-</a></li>
                    <li class="nav_item"><a href="#">GALLERY<br />-ギャラリー-</a></li>
                    <li class="nav_item"><a href="#">ENTRY<br />-説明会に申し込む-</a></li>
                </ul>
            </nav>
        </div>
    </section>

    <!--news    -->
    <section id="news" class="contents-box">
        <h2 class="section-title yellow">NEWS</h2>
        <p class="section-note">お知らせ・更新情報</p>
        <div class="inner">
            <dl class="news-list clearfix">
<?php echo $view ?>
            </dl>
            <!-- link先が作成されていないため一時的に#を設定 -->
            <p class="news-note__more"><a href="#">ニュース一覧を見る</a></p>
        </div>
    </section>

    <!--#feature-->
    <section id="feature" class="contents-box bg-orange">
        <h2 class="section-title white">FEATURE</h2>
        <p class="section-note">特徴</p>
        <div class="inner">
            <ul class="feature-list clearfix">
                <li class="clearfix">
                    <h3 class="point-heading white">POINT<span class="point-count white">1</span></h3>
                    <p class="white">
                        <span class="point-topics">一流職人によるチーズ作り指導</span>
                        基本習得後は2ヶ月間チーズ職人の指導で自家製チーズ完成を目指します。
                    </p>
                </li>
                <li class="clearfix">
                    <h3 class="point-heading white">POINT<span class="point-count white">2</span></h3>
                    <p class="white">
                        <span class="point-topics">960万円までの<br />
                        創業支援出資</span>
                        創業志望者をチーズアカデミー<br />
                        大学院が支援（審査あり）します。
                    </p>
                </li>
                <li class="last clearfix">
                    <h3 class="point-heading white">POINT<span class="point-count white">3</span></h3>
                    <p class="white">
                        <span class="point-topics">初心者歓迎授業料後払い</span>
                        丸暗記ではなく、創りながら。<br />
                        初心者のための授業料後払い制度です。
                    </p>
                </li>
            </ul>
        </div>
    </section>
    <!--end #feature-->

    <!--#concept    -->
    <section id="concept" class="contents-box">
        <h2 class="section-title yellow">CONCEPT</h2>
        <p class="section-note">コンセプト</p>
        <p class="contents-catch">世界を震わすチーズを創ろう。</p>
        <p class="contents-summary">
            今、世界中の人たちが足りないと感じている、栄養素があります。<br />
            その栄養は『カルシウム』と『マグネシウム』<br />
            小さい子供の成長に欠かせないカルシウム<br />
            イライラをなくすには欠かせないカルシウム<br />
            今まで食べたことのないチーズから取れるカルシウム<br />
            そんな悩みを抱えているあなたこそ、<br />
            プロレベルのチーズ作りスキルを持つべきだと思うのです。<br />
        </p>
        <p class="contents-summary">
            できるだけ多くの若い人に本格的なチーズ作りのスキルを学ぶ機会を創りたい。<br />
            そして願わくば、この場所から世界中の多くの人がおいしいと言えるような新感覚のチーズが生まれてほしい。
        </p>
        <p class="contents-summary">
            そんな思いでデジタルハリウッドが<br />
            チーズづくりのためだけの場所「チーズアカデミーTOKYO」をつくりました。
        </p>
        <p class="contents-summary">
            最初は全くの初心者でOK。<br />
            まずは純粋にチーズ作りを楽しんでいただくことから始めて、<br />
            最後には現役で活躍する一流農家のサポートを受けながら<br />
            オリジナルのチーズを開発〜完成させます。
        </p>
        <p class="contents-summary">
            卒業後の「就職」はもちろん「独立」まで、さまざまなサポート企業や<br />
            チーズアクセラレーターがバックアップ。
        </p>
        <p class="contents-summary">さあ、まもなく【CHEESE】への扉がひらかれます。</p>
    </section>
    <!--end #concept-->

    <!--#cource    -->
    <section id="gallery" class="contents-box">
        <div class="contents-heading bg-yellow">
            <h2 class="section-title">COURCE</h2>
            <p class="section-note white">コース紹介</p>
        </div>
        <div class="inner">

            <ul class="cource-list">
                <li class="clearfix">
                    <div class="cource-cap">
                        <img src="image/cource.png" alt="" />
                    </div>
                    <div class="cource-summary">
                        <h4>LABコース</h4>
                        <p>
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                        </p>
                    </div>
                </li>
                <li class="clearfix">
                    <div class="cource-cap-reverse">
                        <img src="image/cource.png" alt="" />
                    </div>
                    <div class="cource-summary-reverse">
                        <h4>LABコース</h4>
                        <p>
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                            週末集中型の初心者対象のチーズ職人養成講座です。
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!--end #cource-->

    <!--#gallery    -->
    <section id="gallery" class="contents-box">
        <div class="contents-heading bg-yellow">
            <h2 class="section-title">GALLERY</h2>
            <p class="section-note white">ギャラリー</p>
        </div>
        <div class="inner">
            <ul class="gallery-list clearfix">
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li class="no-white-space"><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li class="no-white-space"><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
                <li class="no-white-space"><a href=""><img src="image/gallery01.jpg" alt="" /></a></li>
            </ul>
        </div>
    </section>
    <!--end #gallery-->

    <!--#entry    -->
    <section id="entry" class="contents-box">
        <div class="contents-heading bg-orange">
            <h2 class="section-title">ENTRY</h2>
            <p class="section-note">説明会に申し込む</p>
        </div>
        <p class="entry-summary">入学をご希望の方に向けて、学校説明会を実施しております。<br />
フォームからお申し込みください。（無料・完全予約制）</p>
        <button class="entry-btn">
            <p class="entry-btn-title">ENTRY</p>
            <p class="entry-btn-note">説明会に申し込む</p>
        </button>
    </section>
    <!--end #entry-->

    <!--#information-->
    <section id="information" class="contents-box">
        <h2 class="section-title">INFORMATION</h2>
        <p class="section-note">基本情報</p>
        <div class="inner">
            <ul class="footer-list-wrap clearfix">
                <li><img src = "image/space_img.png" alt="space_image" width="300" height="220"></li>
                <li><iframe width="300" height="220" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E3%80%92150-8510+%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%8B%E8%B0%B7%E5%8C%BA%E6%B8%8B%E8%B0%B72-21-1&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=50.435477,91.494141&amp;brcurrent=3,0x60188b5856d2e561:0x967b699ec614e442,0,0x60188b5851109bad:0x66009940d887780c&amp;ie=UTF8&amp;hq=&amp;hnear=%E3%80%92150-0002+%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%B8%8B%E8%B0%B7%E5%8C%BA%E6%B8%8B%E8%B0%B7%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%92%EF%BC%91%E2%88%92%EF%BC%91&amp;t=m&amp;z=14&amp;ll=35.659025,139.703473&amp;output=embed"></iframe></li>
                <li><img src = "image/space_img.png" alt="space_image" width="300" height="220"></li>
            </ul>
        <p class="footer-caution">※実際にはチーズアカデミーという学校は存在しません。<br />
くれぐれも間違ってデジタルハリウッドにお問い合わせすることのないようにご注意ください。</p>
        </div>
    </section>
    <!--end #information-->

</div>
</body>
</html>
