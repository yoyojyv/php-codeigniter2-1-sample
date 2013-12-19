# CodeIgniter 2.1 Sample


CodeIgniter 2.1 을 이용한 샘플 소스 입니다.

## 초기 설정

[CodeIgniter2.1.4 Install Instructions](http://ellislab.com/codeigniter%20/user-guide/installation/index.html) 참조하여 설정.

- application/config/config.php 파일을 열어 base URL을 세팅함. 암호화나 세션을 사용하려면 암호키(encryption key)를 설정.

- 데이터베이스를 사용한다면 application/config/database.php 파일을 열어서 데이터베이스 정보를 설정함.

### 01.
도메인 설정은 local.codeigniter21.com 로 했다고 가정합니다. 실제 사용시 virtual host, hosts 파일을 설정해주세요.

- 먼저 브라우저에서 local.codeigniter21.com 페이지가 잘 뜨는지 확인하세요.


### 02. base url 변경, 기본 controller, view 만들어 보기

- application/config/config.php 파일에서 base_url 정보를 설정

```
$config['base_url']    = 'http://local.codeigniter21.com';
```

- application/config/database.php 파일에서 데이터베이스 정보를 설정.

```
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = '1234';
$db['default']['database'] = 'codeigniter_test_db';
$db['default']['dbdriver'] = 'mysql';
```


- application/config/autoload.php 파일에서 다음의 정보를 변경

```
$autoload['libraries'] = array('database'); // autoloaded
```

- application/config/routes.php 파일에서 다음의 정보를 변경. home controller 가 디폴트 컨트롤러로 설정 됨

```
$route['default_controller'] = "home";
```


- Home Controller 작성. application/controllers/home.php 파일을 다음과 같이 작성

```
<?php
class Home extends CI_Controller {

    public function index() {
        $this->load->view('homepage');
    }

}
```

- view 작성. application/views/homepage.php 파일 작성


```
<html>
<head>
    <title>CodeIgnitor 2.1 Sample</title>
</head>
<body>

<p>Hello, World!</p>

</body>
</html>
```

- http://local.codeigniter21.com/index.php/home 페이지를 열어 페이지가 정상적으로 뜨는지 확인.


- 기본적으로 URL 은 다음과 같은 형식으로 이루어 짐

```
http://local.codeigniter21.com/[controller-class]/[controller-method]/[arguments]
```



