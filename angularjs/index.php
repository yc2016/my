<!DOCTYPE html >
<html>
<head>
	<meta charset="utf-8" />
	<title>测试</title>
	<script src="./js/angular-1.2.2/angular.min.js"></script>
	<script src="./js/angular-1.2.2/angular-route.min.js"></script>
</head>
<body ng-app="myApp">
	<!--
	<div ng-controller="TextController">
		<p>{{someText}}</p>
	</div>
	-->
	<a href="#/binding">计算器</a>
	<a href="#/form">表单验证</a>
	<a href="#/list">mvc</a>
	<a href="selected.html" target="_blank">selected</a>
	<div ng-view></div>
</body>
  <script>
    var myApp = angular.module('myApp', ['ngRoute']);
    myApp.controller('TextController', function ($scope) {
		$scope.someText = '测试显示内容';
    });
	var app = angular.module('myApp_1', []);
	app.controller('myCtrl', function($scope) {
	   $scope.sites = [
			{site : "Google", url : "http://www.google.com"},
			{site : "Runoob", url : "http://www.runoob.com"},
			{site : "Taobao", url : "http://www.taobao.com"}
		];
	});

    //路由
    function emailRouteConfig($routeProvider) {
		$routeProvider.
		when('/default', {
			controller: ListController,
			templateUrl: 'default.html'
		}).
		when('/binding', {
			controller: ListController,
			templateUrl: 'binding.html'
		}).
		when('/selected', {
			controller: ListController,
			templateUrl: 'selected.html'
		}).
		when('/list', {
			controller: ListController,
			templateUrl: 'list.html'
		}).
		when('/show', {
			controller: ListController,
			templateUrl: 'show.html'
		}).
		when('/form', {
			controller: ListController,
			templateUrl: 'form.html'
		}).
		when('/view/:id', { //在id前面加一个冒号，从而制订了一个参数化URL
			controller: DetailController,
			templateUrl: 'detail.html'
		}).
		otherwise({
			redirectTo: '/default'
		});
    }

    myApp.config(emailRouteConfig);//配置我们的路由

    messages = [
		<?PHP
			for($i1=0;$i1<=10;$i1++){
				echo "
				{
					id: {$i1},
					sender: \"18210427950@qq.com\",
					subject: \"你好，这是一封邮件\",
					date: \"".date("Y年m月d日",time())."\",
					recipients: ['".rand(100000000,999999999)."@163.com'],
					message: \"你好，我是xxx，这是发送给您的邮件。\"
				},
				";
			}
		?>
	];

    function ListController($scope) {
		$scope.messages = messages;
    }

    function DetailController($scope,$routeParams) {
		$scope.message = messages[$routeParams.id];
    }
  </script>
</html>