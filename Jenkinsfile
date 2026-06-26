pipeline {
   agent any

   stages {

       stage('Checkout') {
           steps {
               checkout scm
           }
       }

       stage('Test PHP') {
           steps {
               sh 'php -l plataforma/processa.php'
           }
       }

       stage('Build') {
           steps {
               sh 'docker compose build'
           }
       }

       stage('Deploy') {
           steps {
               sh '''
                   docker compose down || true
                   docker compose up -d
               '''
           }
       }

       stage('Verificar') {
           steps {
               sh 'docker ps'
           }
       }
   }
}
