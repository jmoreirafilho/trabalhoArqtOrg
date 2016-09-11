// function Main() {
// 	Main.prototype.lerArquivoTxt();
// };

// Main.prototype.lerArquivoTxt = function() {
// 	var file = "file:///C:/Users/Airton%20Filho/Documents/trabalhoArqtOrg/asm.txt";
// 	angular.module('app', []);
// 	angular.module('app').controller('controller', function($scope, $http) {
// 	console.log("entrou");
// 		$http.get(file).success(function (data) {
// 			console.log(data);
// 		}).error(function (error) {
// 			console.log("Erro");
// 			console.log(error);
// 		});
// 	});
// }

// Main();

	var file = "file:///C:/Users/Airton%20Filho/Documents/trabalhoArqtOrg/asm.txt";
$(function(){
    $.ajax({
        url: "../asm.txt",
        async: true,   // asynchronous request? (synchronous requests are discouraged...)
        cache: false,   // with this, you can force the browser to not make cache of the retrieved data
        dataType: "text",  // jQuery will infer this, but you can set explicitly
        success: function( data, textStatus, jqXHR ) {
            var resourceContent = data; // can be a global variable too...
            // process the content...
        }
    });
});