<div ng-app ng-controller="SearchCtrl">
	<form class="well form-search">
		<label>Search:</label>
		<input type="text" ng-model="keywords" class="input-medium search-query" placeholder="Keywords...">
		<button type="submit" class="btn" ng-click="search()">Search</button>
		<p class="help-block">Try for example: "php" or "angularjs" or "asdfg"</p>		
    </form>
<pre ng-model="result">
{{result}}
</pre>
   </div>