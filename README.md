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

### 03. 로그찍기, Routing 이해하기

다음은 [Tutorial − Static pages](http://ellislab.com/codeigniter%20/user-guide/tutorial/static_pages.html) 를 참조하여 작성되었습니다.

- 먼저 로그를 찍어보기 위해 application/config/config.php 파일에서 로깅 설정을 다음과 같이 수정.

- log_path 권한은 적절하게 설정해야 함. 권한이 없을시 파일이 생성되지 않음.

```
$config['log_threshold'] = 2;
$config['log_path'] = 'application/logs/';
```

- 다음의 경로정보를 다시 한번 확인해 보세요.

```
http://local.codeigniter21.com/[controller-class]/[controller-method]/[arguments]
```

- Pages 컨트롤러를 생성합니다. application/controllers/pages.php 생성

```
<?php

class Pages extends CI_Controller {

	public function view($page = 'home')
	{

	}
}
```



- http://local.codeigniter21.com/index.php/pages 페이지로 접근하여 404 페이지를 확인합니다.

- http://local.codeigniter21.com/index.php/pages/view 페이지로 접근하면 빈 페이지가 뜹니다.


이제 페이지가 나타나도록 작업을 합시다.

먼저, 공통으로 쓰일 두개의 템플릿을 생성합니다.

- application/views/templates/header.php 에 `header` 를 생성합니다.

```
<html>
<head>
	<title><?php echo $title ?> - CodeIgniter 2 Tutorial</title>
</head>
<body>
	<h1>CodeIgniter 2 Tutorial</h1>
```

- application/views/templates/footer.php 에 `footer` 를 생성합니다.

```
<strong>&copy; 2011</strong>
</body>
</html>
```

다음으로 Page Controller 에 다음의 내역을 넣어줍니다. (application/controllers/pages.php)
- 주석 부분에 로그 찍는 부분을 확인하세요.

```
<?php
class Pages extends CI_Controller {

    public function view($page = 'home') {

        log_message('debug', '**page : '.$page);  // 'debug' 레벨로 로그 찍기

        if ( ! file_exists('application/views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

}
```

다음으로 application/views/pages/ 디렉토리에 view 파일인 `home.php`, `about.php` 두 개의 파일을 생성합니다.

- home.php

```
<p>application/views/pages/home.php, <?=$title?></p>
```

- about.php

```
<p>application/views/pages/about.php, <?=$title?></p>
```

- 저장 후 http://local.codeigniter21.com/index.php/pages/view, http://local.codeigniter21.com/index.php/pages/view/about 페이지가 뜨는지 확인을 합니다.


다음 너무 긴 URL 을 routing rule을 이용하여 줄여봅시다.

- application/config/routes.php 파일에서 기존 $route array 를 제거하고 다음의 내역을 넣어줍니다.


```
$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';
```


http://local.codeigniter21.com/index.php, index.php/about 페이지에 접근하여 올바른 view 페이지가 뜨는지 확인합니다.



### 04. Model 생성 후, 실제 돌아가는 간단한 어플리케이션 만들기(리스트, 상세 뷰 페이지)

다음은 [Tutorial − News section](http://ellislab.com/codeigniter%20/user-guide/tutorial/news_section.html) 를 참조하여 작성되었습니다.

작업하기에 앞서 먼저 routing 정보를 수정해 줍니다. 다음의 두개만 남기도 다 주석처리 해주세요

```
$route['default_controller'] = "home";
$route['404_override'] = '';
```

Model 을 만들어 줍니다.

- application/models 디렉토리에 news_model.php 를 생성합니다.


```
<?php
class News_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
}
```



- `news` table 을 생성해 줍니다.

```
CREATE TABLE news (
	id int(11) NOT NULL AUTO_INCREMENT,
	title varchar(128) NOT NULL,
	slug varchar(128) NOT NULL,
	text text NOT NULL,
	PRIMARY KEY (id),
	KEY slug (slug)
);
```

- database 와 model 이 세팅이 되었다면, 모든 post 내용을 가져오는 메소드가 필요합니다. 여기에는 CodeIgniter 의 database abstraction layer 를 이용합니다. [Active Record Class](http://ellislab.com/codeigniter%20/user-guide/database/active_record.html) 를 참조하세요. 다음의 코드를 model 에 추가합니다.


```
public function get_news($slug = FALSE)
{
	if ($slug === FALSE)
	{
		$query = $this->db->get('news');
		return $query->result_array();
	}

	$query = $this->db->get_where('news', array('slug' => $slug));
	return $query->row_array();
}
```

위의 코드는 두개의 query 를 실행합니다. 하나는 모든 news record 를 가져오고, 다른 하나는 조건을 이용해 record 를 가져옵니다.



News 보여주기.
- News Controller 를 생성합니다. (application/controllers/news.php)

```
<?php
class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
	}

  public function index()
  {
      $data['news'] = $this->news_model->get_news();
      $data['title'] = 'News archive';

      $this->load->view('templates/header', $data);
      $this->load->view('news/index', $data);
      $this->load->view('templates/footer');
  }

	public function view($slug)
	{
		$data['news'] = $this->news_model->get_news($slug);
	}
}
```

- view 파일을 생성합니다. (application/views/news/index.php)


```
<?php foreach ($news as $news_item): ?>

    <h2><?php echo $news_item['title'] ?></h2>
    <div id="main">
        <?php echo $news_item['text'] ?>
    </div>
    <p><a href="news/<?php echo $news_item['slug'] ?>">View article</a></p>

<?php endforeach ?>
```

- 리스트 페이지를 확인하기 전에 database에 다음의 테스트 데이터를 넣어줍니다.

```
insert into `codeigniter_test_db`.`news` ( `title`, `id`, `text`, `slug`) values ( 'title1', '0', 'text1', 'slug1');
insert into `codeigniter_test_db`.`news` ( `title`, `id`, `text`, `slug`) values ( 'title2', '0', 'text2', 'slug2');

```


- 리스트 페이지가 정상적으로 출력되는지 확인후 controller 의 view 메소드를 다음과 같이 수정합니다.


```
public function view($slug)
{
	$data['news_item'] = $this->news_model->get_news($slug);

	if (empty($data['news_item']))
	{
		show_404();
	}

	$data['title'] = $data['news_item']['title'];

	$this->load->view('templates/header', $data);
	$this->load->view('news/view', $data);
	$this->load->view('templates/footer');
}
```


- 해당 액션의 view 도 만들어 줍니다. (application/views/news/view.php)

```
<?php
echo '<h2>'.$news_item['title'].'</h2>';
echo $news_item['text'];
```

- 다음 routing 정보를 다음과 같이 수정합니다.

```
$route['news/(:any)'] = 'news/view/$1';
$route['news'] = 'news';
$route['(:any)'] = 'pages/view/$1';
$route['default_controller'] = 'pages/view';
```

- http://local.codeigniter21.com/index.php/news 의 경로로 접근하여 리스트, 상세 뷰 페이지가 이상없이 뜨는지 확인합니다.



### 05. news 생성 페이지 만들기
[Tutorial - Create news items](http://ellislab.com/codeigniter%20/user-guide/tutorial/create_news_items.html) 를 참조하여 작성되었습니다.
위의 링크는 한번 확인해 보고 코드를 작성해 주세요.

- create form 페이지를 만듭니다. (application/views/news/create.php)


```
<h2>Create a news item</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('news/create') ?>

<label for="title">Title</label>
<input type="input" name="title" /><br />

<label for="text">Text</label>
<textarea name="text"></textarea><br />

<input type="submit" name="submit" value="Create news item" />

</form>
```

- Model 수정

```
public function set_news()
{
	$this->load->helper('url');

	$slug = url_title($this->input->post('title'), 'dash', TRUE);

	$data = array(
		'title' => $this->input->post('title'),
		'slug' => $slug,
		'text' => $this->input->post('text')
	);

	return $this->db->insert('news', $data);
}
```



- Routing 정보 수정

$route array 제일 위에 다음을 추가합니다.

```
$route['news/create'] = 'news/create';
```



