(function(){
    var app = angular.module('chat-app', []);
    
    app.directive('webChat', function() {
        return {
            restrict: 'E',
            templateUrl: 'frontend/chat/templates/chat.html',
            scope: {url: "@urlWebSocket", class: "@class"},
            controller: ['$scope', '$http', function($scope, $http) {
                this.logMensagem = [];
                this.isConectado = false;
                this.mensagem = {texto: '', autor: ''};
                
                this.ws = new WebSocket($scope.url);
                this.class = $scope.class;
                this.ws.$scope = $scope;
                this.ws.ref = this;
                
                $http.get('http://localhost:8080').success(function(r){console.log('deu certo');});
                
                
                this.ws.onopen = function(erro) {
                    this.ref.isConectado = true;
                    this.$scope.$apply();
                    this.send('Nova conexão!');
                };
                this.ws.onmessage = function(entrada) {
                    this.ref.addMensagemNoLog({texto: entrada.data, autor: ''});
                    this.$scope.$apply();
                };
                this.ws.onclose = function(e) {
                    this.ref.isConectado = false;
                    this.$scope.$apply();
                };
                this.ws.onerror = function(e) {
                    this.ref.isConectado = false;
                    this.$scope.$apply();
                };
                this.enviarMensagem = function () {
                    this.ws.send(this.mensagem.texto);
                    
                    this.mensagem = {
                        texto: '', 
                        autor: ''
                    };
                };
                this.addMensagemNoLog = function (mensagem){
                    if (this.isConectado) {
                        this.logMensagem.push(mensagem);
                        $scope.$apply();
                        var height = angular.element("#caixaMensagens").get(0).scrollHeight;
                        angular.element("#caixaMensagens").get(0).scrollTop =  height;
                    }
                };
            }], 
            controllerAs: 'chat'
        };
    });
})();


