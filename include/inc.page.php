<?php
class page{

    private $pdo;
    private $content;
    function __construct()// конструктор класса
    {
        $this->dbcon();//создаем подключение к локальному серверу и базам данных через PDO

        $this->router();//функция которая определяет нужную нам функцию

        $this->out();//функция вывода пользователей на экран
    }

    function router(){//благодаря условным операторам смотрим в url нужную на функцию и методом GET определяем нужную

        if (isset($_GET["reg"])){

            $this->reg();

        }
        elseif (isset($_GET["add"])){

            $this->add();

        }
        elseif (isset($_GET["edit"])){

            $this->edit();

        }
        elseif (isset($_GET["saveinfo"])){

            $this->saveinfo();

        }
        elseif (isset($_GET["del"])){

            $this->del();

        }
        elseif (isset($_GET["compare"])){

            $this->compare();

        }
        elseif(isset($_GET["page"])){
            $this->showlist();
        }
        else{
            $this->auth();
        }
    }




    function compare(){
        if (($_POST["login"]=='admin')&&($_POST["password"]=='admin'))
            $this->showlist();
        else {
            $this->auth();
            $this->content.='<h4>Неправильный логин администратора или пароль</h4>';
        }
    }




    function auth(){
        $this->content = file_get_contents("html/auth.html");
    }




    function edit(){
        $sql = "select * from  `accounts`  where `id`=:id ";//создаем запрос в БД для определения нужного нам аккаунта для дальнейшего редактирования
        $load_account=$this->pdo->prepare($sql);//определяем аккаунт
        $load_account->execute(array("id"=>$_GET["edit"]));//загружаем аккаунт для редакции

        if ($row = $load_account->fetch()){//проверяем загрузили ли мы аккаунт в переменную


            $tmpl = file_get_contents("html/edit.html");//выгружаем на страницу форму для редактирования из файла edit.html


            foreach ($row as $key => $value){// с помощью ассоциативного массива редактируем содержание полей путем замены изначального содержания на то,которое мы редактировали

                $tmpl = str_replace("{[".$key."]}",$value,$tmpl);


            }

            $this->content.=$tmpl;//выгружаем редактированный аккаунт


        }
        else{//если мы не нашли нужного для редактированния аккаунта-выходим в корневой файл сайта
            $this->showlist();
        }



    }




    function  del(){
        $sql = "update `accounts` set `del` =1 where `id`=:id ";//честно говоря мы не удаляем аккаунт полностью,он остается в БД,мы просто маркеруем
        $upd_account=$this->pdo->prepare($sql);// его единицей,а затем при выводе мы просто не выводим на экран аккаунты с единицей в поле del
        $upd_account->execute(array("id"=>$_GET["del"]));
        $this->showlist();
    }

    function saveinfo(){//функция для сохранения данных введенного аккаунта с сайта в БД через PDO

        try{

            if(empty($_POST['login'])) exit("Поле login не заполнено");//выводим ошибку пользователю из-за незаполнения обязательных полей
            if(empty($_POST['password'])) exit("Поле password не заполнено");
            if(empty($_POST['first_name'])) exit("Поле имя не заполнено");
            if(empty($_POST['last_name'])) exit("Поле фамилия не заполнено");
            if(empty($_POST['sex'])) exit("Поле пол не заполнено");
                elseif ((($_POST['sex'])<>'male')&&(($_POST['sex'])<>'female'))exit("Поле пол заполнено неправильно");
            if(empty($_POST['date_of_birth'])) exit("Поле дата не заполнено");





            $sql = "update  `accounts` set `login` = :login, `password` = :password, `first_name` = :first_name, `last_name` = :last_name, `sex` = :sex, `date_of_birth` = :date_of_birth where `id` = :id ";//создаем запрос БД для сохранения в ее конкретные поля наше содержание,а так же даем каждому аккаунту свой id
            $upd_account=$this->pdo->prepare($sql);
            $upd_account->execute(array(//заполняем поля в БД введенными пользоввателем значениями
                "login"=>$_POST["login"],
                "password"=>$_POST["password"],
                "first_name"=>$_POST["first_name"],
                "last_name"=>$_POST["last_name"],
                "sex"=>$_POST["sex"],
                "date_of_birth"=>$_POST["date_of_birth"],
                "id"=>$_GET["saveinfo"]
            ));


            $this->showlist();
        }
        catch(PDOException $exception)//если что-то пошло не так-выводим ошибку на экран
        {
            $this->content.= $exception->getMessage();
        }


    }



    function add(){//функция для занесения введенного аккаунта с сайта в БД через PDO

        try{

            if(empty($_POST['login'])) exit("Поле login не заполнено");//выводим ошибку пользователю из-за незаполнения обязательных полей
            if(empty($_POST['password'])) exit("Поле password не заполнено");
            if(empty($_POST['first_name'])) exit("Поле имя не заполнено");
            if(empty($_POST['last_name'])) exit("Поле фамилия не заполнено");
            if(empty($_POST['sex'])) exit("Поле пол не заполнено");
            elseif ((($_POST['sex'])<>'male')&&(($_POST['sex'])<>'female'))exit("Поле пол заполнено неправильно");
            if(empty($_POST['date_of_birth'])) exit("Поле дата не заполнено");





            $sql = "INSERT INTO `accounts` (`login`, `password`, `first_name`, `last_name`, `sex`, `date_of_birth`)
                    VALUES ( :login, :password, :first_name, :last_name, :sex, :date_of_birth)"; //создаем запрос БД для добавления в ее конкретные поля наше содержание
            $new_account=$this->pdo->prepare($sql);
            $new_account->execute(array(//заполняем поля в БД введенными пользоввателем значениями
                "login"=>$_POST["login"],
                "password"=>$_POST["password"],
                "first_name"=>$_POST["first_name"],
                "last_name"=>$_POST["last_name"],
                "sex"=>$_POST["sex"],
                "date_of_birth"=>$_POST["date_of_birth"]
            ));

            $this->showlist();
        }
        catch(PDOException $exception)//если что-то пошло не так-выводим ошибку на экран
        {
            $this->content.= $exception->getMessage();
        }


    }

    function reg (){//перенаправляем пользователя на страницу с формой регистрации аккаунта

        $this->content .= file_get_contents("html/reg.html");

    }


    function showlist()
    {//функция для транслирования контента на сайте

        $cnt = 6;//кол-во аккаунтов на 1 странице
        $fst = 0;//первый выведенный на странице аккаунт

        $p = 1;


        $query = $this->pdo->query('SELECT count(`id`) as `cnt` FROM `accounts` where `del` =0');//запрос на БД осуществляющий трансляцию всех аккаунтов из БД кроме тех у которых в поле del стоит 1
        $row = $query->fetch();
        $ttlcnt = $row["cnt"];

        $ttlpages = intval($ttlcnt / 6);//ищем количество полных страниц(страниц с 6 аккаунтами)
        if (intval($ttlcnt) % 6) {//если у нас все страницы переполнены аккаунтами,а аккаунты еще есть-создаем для них новую страницу
            $ttlpages++;
        }

        if (isset($_GET["page"])) {//если мы уже находимся на какой-то странице
            $p = $_GET["page"];
        }
        $fst = ($p - 1) * $cnt;//первый выведенный на странице аккаунт

        $pgntion = "";//объявляем переменную

        for ($i = 1; $i <= $ttlpages; $i++) {//определяем страницу на которой мы находимся активной
            $sact = "";//объявляем переменную
            if ($i == $p) {
                $sact = "active";
            }
            $pgntion .= "  <li class=\"page-item $sact\"><a class=\"page-link\" href=\"/?page=" . $i . "\">" . $i . "</a></li>\n";
        }

        $pprev = "";//объявляем переменную
        if ($p > 1) {
            $pprev = " <li class=\"page-item\"><a class=\"page-link\" href=\"?page=" . intval($p - 1) . "\"><<</a></li>";

        }
        $pnxt = "";
        if ($p < $ttlpages) {


            $pnxt = " <li class=\"page-item\"><a class=\"page-link\" href=\"?page=" . intval($p + 1) . "\"> >> </a></li>";

        }

        $pagination = "
        
<nav aria-label=\"Page navigation example\">
  <ul class=\"pagination\">
   $pprev    
    $pgntion  
   $pnxt    
  </ul>
</nav>
        ";


        $this->content = '<ul>';
        $query = $this->pdo->query('SELECT * FROM `accounts` where `del` =0 ORDER BY `id` DESC limit ' . $fst . ',' . $cnt);//запрос на БД осуществляющий трансляцию всех аккаунтов из БД кроме тех у которых в поле del стоит 1,а так же принимает значения первого аккаунта на странице и количества аккаунтов выводимых на странице
        while ($row = $query->fetch())//проверяем пуста ли переменная с запросом
        {
            $this->content .= '<li class="spisok"><b>' . $row["login"] . '</b>
<div class="btn-group">
<a href="/?del=' . $row["id"] . '" onclick="return confirm(\'Вы действительно хотите удалить пользователя?\')"><button>Удалить</button></a>
<a href="/?edit=' . $row["id"] . '"><button>Просмотр и изменение</button></a>
</div>
';
        }
        $this->content .= '</ul>';
        $this->content .= $pagination . '<a class="btn btn-success" href = "/?reg">Добавить пользователя</a>';


    }

    function out(){

        $tmpl = file_get_contents("html/page.html");

        $tmpl = str_replace("{[content]}",$this->content,$tmpl);//меняем местами метку {[content]} с нашими аккаунтами и кнопками

        echo $tmpl;//выводим все аккаунты с кнопки на страницу


    }

    function dbcon(){//создаем подключение к БД через PDO


        $type="mysql";
        $host="localhost";
        $base="database";
        $user="root";
        $pasw="";

        $dsn = $type.":host=".$host.";dbname=".$base;
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $this->pdo = new PDO($dsn, $user, $pasw, $opt);



    }


}