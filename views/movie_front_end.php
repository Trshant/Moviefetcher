<!DOCTYPE html>
<html>
    <head>
        <title>Movie Info</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js"></script>
        <script src="https://code.angularjs.org/1.2.16/angular-route.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js"></script>
		<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=trshant" async="async"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/min/1.5/min.min.css">
        <style>
  		* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    font-family: sans-serif;
}
 
body, html { margin: 0; height: 100%; }

div.main {
  width: 1000px;
  height: 100%;
  margin: 0 auto;
  padding-top: 5px;
  overflow:auto;
  padding-bottom: 50px;
}

p { margin: 0; }
input { width: 100%; 
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	border: 2px solid red;
	background-color: brown;
	color: white;
	 font-size: 18px;
	 font-weigth: bold ;
	
	 }
 
pre {
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;
    white-space: -o-pre-wrap;
    word-wrap: break-word;
}
 
div.repo {
    border: 1px solid;
    cursor: pointer;
    -webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	margin-top: 5px;
	padding: 3px;
}
 
div.repo a {
  text-decoration: none;
  color: black;
}
#wrap {min-height: 100%;}

#footer {position: relative;
	margin-top: -50px; /* negative value of footer height */
	height: 50px;
	clear:both;} 

#search, #repo, #user { float: left; }
#search { width: 20%; }
#repo { width: 60%; margin-left: 10px;  }
#user { width: 20%; }
</style>
<script>
var app = angular.module('githubsearch', ['ngRoute']);
app.factory('GitHub', function GitHub($http) {
    return {
		searchRepos: function searchRepos(query, callback) {
			// http://www.omdbapi.com/?s=indiana
			$http.get('http://localhost/CodeIgniter/index.php/api/search/'+ query )
				.success(function (data) {
					console.log("github");
					callback(null, data);
				})
				.error(function (e) {
					callback(e);
				});
		} ,
		
		getRepo: function getRepo(name, callback) {
			console.log("gh2        "+'http://www.omdbapi.com/?i='+name+'&plot=full');
			$http.get('http://localhost/CodeIgniter/index.php/api/movie/'+name)
			.success(function (data) {
				callback(null, data);
			})
			.error(function (e) {
				callback(e);
			});
		} 
 
    };
});




app.controller('SearchController',function SearchController($scope, GitHub) {
		 $scope.executeSearch = function executeSearch() {
			 console.log("cont");
			GitHub.searchRepos($scope.query, function (error, data) {
				if (!error) {
					console.log( data.Search.length )
					$scope.repos =  _.filter( data.Search , function(movie){ return movie.Type == 'movie'; } );
					console.log(  _.filter( data.Search , function(movie){ return movie.Type == 'movie'; } ).length );
				}
			});
		} ,
		
		$scope.openRepo = function openRepo(name) {
			console.log("cont2");
			GitHub.getRepo(name, function (error, data) {
				if (!error) {
					$scope.activeRepo = data;
		 
				}
			});
		}
});

app.controller('MainCtrl', function($scope, GitHub , $routeParams) {
    console.log("main");
    data = $routeParams.imdbId ;
    console.log(data);
    GitHub.getRepo(data, function (error, data ) {
	if (!error) {
		$scope.activeRepo = data; 
	}});
}) ;


app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
     when('/home', {
	templateUrl: 'withoutdata.html',
	controller: 'MainCtrl'
      }).

      when('/s/:imdbId', {
	templateUrl: 'withdata.html',
	controller: 'MainCtrl'
      }).
      otherwise({
	redirectTo: '/home'
      });
}]);

</script>        
    </head>
    <body>
	<div id="wrap">
	<div class="main" ng-app="githubsearch" >
	<div id="search" ng-controller="SearchController">
		<input ng-model="query" id="ipt" placeholder="Enter film name" ng-keyup="$event.keyCode == 13 && executeSearch()">
		<div class="repo" ng-repeat="repo in repos">
			<a href="#/s/{{ repo.imdbID }}">
				<strong>{{ repo.Title }}</strong>
				<p>{{ repo.Year }}</p>
			</a>
		</div>
	</div>
	
	<div id="repo" ng-view ng-controller="MainCtrl">
	</div>

	<script type="text/ng-template" id="withdata.html">
		<h2>{{ activeRepo.Title }}</h2> <em>({{ activeRepo.Year }})</em>
		<div class="addthis_native_toolbox"></div>
		<img style="float:left;margin: 5px;" src="{{activeRepo.Poster}}">
		<p><em>Directed By</em> {{activeRepo.Director}}</p>
		<p><em>Actors :</em> {{activeRepo.Actors}}</p>
   		<p><em>IMDb Rating :</em> {{activeRepo.imdbRating}}/10</p>
		<pre>{{ activeRepo.Plot }}</pre>
	</script>

	<script type="text/ng-template" id="withoutdata.html">
	</script>


	</div>
	</div>
    <div id="footer">
		Made by <a href="http://trshant.neocities.org">Trshant</a>. Uses <a href="https://angularjs.org/">Angular.js</a>, <a href="http://underscorejs.org">Underscore.js</a> , <a href="http://www.omdbapi.com/">OmdbAPI</a>. Code on <a href="">GitHub</a>.
	</div>

	

    </body onLoad="document.getElementById(\"ipt\").focus();">
</html>
