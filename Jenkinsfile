pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: '${APP_BRANCH_ENV}', credentialsId: 'AdamoDeployGitlab', url: '${APP_GIT}'
            }
        }
        stage('Prepare') {
            steps {
                // remove build directories

                sh "rm -rf ${buildDir}api"
                sh "rm -rf ${buildDir}code-browser"
                sh "rm -rf ${buildDir}coverage"
                sh "rm -rf ${buildDir}logs"
                sh "rm -rf ${buildDir}pdepend"
                // create build directories
                sh "mkdir -p ${buildDir}api"
                sh "mkdir -p ${buildDir}code-browser"
                sh "mkdir -p ${buildDir}coverage"
                sh "mkdir -p ${buildDir}logs"
                sh "mkdir -p ${buildDir}pdepend"


                 contentReplace(configs: [
                    fileContentReplaceConfig(
                        configs: [
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$APP_NAME', search: '#APP_NAME#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$APP_ENV', search: '#APP_ENV#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$APP_DEBUG', search: '#APP_DEBUG#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$APP_URL', search: '#APP_URL#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$LOG_CHANNEL', search: '#LOG_CHANNEL#'),

                        
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_HOST', search: '#DB_HOST#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_CONNECTION', search: '#DB_CONNECTION#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_PORT', search: '#DB_PORT#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_DATABASE', search: '#DB_DATABASE#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_USERNAME', search: '#DB_USERNAME#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$DB_PASSWORD', search: '#DB_PASSWORD#'),
                            
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_HOST', search: '#REDIS_HOST#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_PASSWORD', search: '#REDIS_PASSWORD#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_PORT', search: '#REDIS_PORT#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_PREFIX', search: '#REDIS_PREFIX#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_DB', search: '#REDIS_DB#'),
                            
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$REDIS_CLIENT', search: '#REDIS_CLIENT#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$BROADCAST_DRIVER', search: '#BROADCAST_DRIVER#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$CACHE_DRIVER', search: '#CACHE_DRIVER#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$QUEUE_CONNECTION', search: '#QUEUE_CONNECTION#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$SESSION_DRIVER', search: '#SESSION_DRIVER#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$SESSION_LIFETIME', search: '#SESSION_LIFETIME#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$QUEUE_DRIVER', search: '#QUEUE_DRIVER#'),


                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_DRIVER', search: '#MAIL_DRIVER#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_HOST', search: '#MAIL_HOST#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_PORT', search: '#MAIL_PORT#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_USERNAME', search: '#MAIL_USERNAME#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_PASSWORD', search: '#MAIL_PASSWORD#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_ENCRYPTION', search: '#MAIL_ENCRYPTION#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_FROM_ADDRESS', search: '#MAIL_FROM_ADDRESS#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_FROM_NAME', search: '#MAIL_FROM_NAME#'),
                            fileContentReplaceItemConfig(matchCount: 0, replace: '$MAIL_CC_ADDRESS', search: '#MAIL_CC_ADDRESS#'),


                        ],
                        fileEncoding: 'UTF-8', filePath: '.env.example')
                    ])
                sh "cp .env.example .env"

            }
        }

        stage('Composer') {
            steps {
                sh 'composer update'
                sh 'composer install --ignore-platform-reqs'
                sh 'composer dump-autoload'
                sh 'php artisan key:generate --force'
            }
        }
        stage('Code Tests and Documentation') {
            steps {
                // code sniffer
                sh "phpcs --report=checkstyle --report-file=${buildDir}logs/checkstyle.xml --standard=${buildDir}phpcs.xml --extensions=php,inc --ignore=autoload.php --ignore=vendor/ app || exit 0"
                // mess detector
                sh "phpmd app xml ${buildDir}phpmd.xml --reportfile ${buildDir}logs/pmd.xml --exclude vendor/ --exclude autoload.php || exit 0"
                // copy&paste detector
                sh "phpcpd --log-pmd ${buildDir}logs/pmd-cpd.xml --exclude vendor app || exit 0"
                // lines of code
                sh "phploc --count-tests --exclude vendor/ --log-csv ${buildDir}logs/phploc.csv --log-xml ${buildDir}logs/phploc.xml app"
                // software metrics
                sh "pdepend --jdepend-xml=${buildDir}logs/jdepend.xml --jdepend-chart=${buildDir}pdepend/dependencies.svg --overview-pyramid=${buildDir}pdepend/overview-pyramid.svg --ignore=vendor app"
                // php documentation generator
                sh "phpdox -f ${buildDir}phpdox.xml || exit 0"
            }
        }
        stage('Publish Reporting') {
            steps {
                junit(testResults: "${buildDir}logs/junit.xml", allowEmptyResults: true)
                step([$class: 'CloverPublisher',
                    cloverReportDir: "${buildDir}coverage",
                    cloverReportFileName: 'clover.xml',
                    healthyTarget: [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80], // optional, default is: method=70, conditional=80, statement=80
                    unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50], // optional, default is none
                    failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]     // optional, default is none)
                ])
                checkstyle pattern: "${buildDir}logs/checkstyle.xml"
                recordIssues enabledForFailure: true, tool: pmdParser(pattern: "${buildDir}logs/pmd.xml")
                recordIssues enabledForFailure: true, tool: cpd(pattern: "${buildDir}logs/pmd-cpd.xml")
                sh "echo '<html><head><title>PHP Dependency</title></head><body></body><img src=\"dependencies.svg\"></br><img src=\"overview-pyramid.svg\"></html>' > ${buildDir}pdepend/index.html"
                publishHTML (target: [
                    allowMissing: true,
                    alwaysLinkToLastBuild: true,
                    keepAll: true,
                    reportDir: "${buildDir}pdepend",
                    reportFiles: 'index.html',
                    reportName: "PHP Dependencies"
                ])
                publishHTML (target: [
                    allowMissing: true,
                    alwaysLinkToLastBuild: true,
                    keepAll: true,
                    reportDir: "${buildDir}api/docs/html",
                    reportFiles: 'index.xhtml',
                    reportName: "PHPDox Documentation"
                ])
            }
        }
        stage('Deployment') {
            steps {
                sh "rsync -rltvz --no-p -O --delete --exclude-from=.deployment_exclude -e ssh . ${SSH_SERVER}:${SERVER_PATH}"
                sh """ssh -tt ${SSH_SERVER} << EOF
                        cd ${SERVER_PATH}
                        sudo rm ${SERVER_PATH}/storage
                        sudo rm ${SERVER_PATH}/storage/app/public
                        sudo rm ${SERVER_PATH}/public/storage ${SERVER_PATH}/public/uploads
                        
                        sudo mkdir -p storage/framework/cache/data
                        sudo mkdir -p storage/framework/cache
                        sudo mkdir -p storage/framework/sessions
                        sudo mkdir -p storage/framework/views
                        sudo mkdir -p storage/logs
                        sudo mkdir -p storage/debugbar
                        sudo mkdir -p bootstrap/cache
                        sudo chmod -R 777 storage bootstrap
                        
                        sudo ln -s ${STORAGE_PATH} ${SERVER_PATH}/storage/app/public
                        sudo ln -s ${STORAGE_LINK} ${SERVER_PATH}/public/uploads
                        sudo chown -R jenkins:www-data ${SERVER_PATH}/storage ${SERVER_PATH}/public/uploads
                        sudo chmod -R 777 ${SERVER_PATH}/storage ${SERVER_PATH}/public/uploads

                        php artisan cache:clear
                        php artisan config:clear
                        php artisan migrate --force
                        php artisan storage:link
                        php artisan route:clear

                        exit
                        EOF"""

            }
        }

    }
       post {
      failure {
script {
               def GIT_LAST_COMMIT_DESCRIPTION = sh(script: 'git log --format="medium" --raw -1 ${GIT_COMMIT}', returnStdout: true).trim()
                telegramSend message: """
*[${JOB_NAME.toString().toUpperCase()}]* Build [#$BUILD_NUMBER]($BUILD_URL) ⛔️️${currentBuild.currentResult}
```
$GIT_LAST_COMMIT_DESCRIPTION
```
""", chatId: "${APP_TELEGRAM_CHANNEL}"
           }
      }
      unstable {


script {
               def GIT_LAST_COMMIT_DESCRIPTION = sh(script: 'git log --format="medium" --raw -1 ${GIT_COMMIT}', returnStdout: true).trim()
                telegramSend message: """
*[${JOB_NAME.toString().toUpperCase()}]* Build [#$BUILD_NUMBER]($BUILD_URL) ⚠️ ️️${currentBuild.currentResult}
```
$GIT_LAST_COMMIT_DESCRIPTION
```
""", chatId: "${APP_TELEGRAM_CHANNEL}"
           }

      }
      success {
         script {
               def GIT_LAST_COMMIT_DESCRIPTION = sh(script: 'git log --format="medium" --raw -1 ${GIT_COMMIT}', returnStdout: true).trim()
               telegramSend message: """
*[${JOB_NAME.toString().toUpperCase()}]* Build [#$BUILD_NUMBER]($BUILD_URL) ✅️ ${currentBuild.currentResult}
```
$GIT_LAST_COMMIT_DESCRIPTION
```
""", chatId: "${APP_TELEGRAM_CHANNEL}"
           }

      }
    }
    environment {
        buildDir = 'build/'
    }
}
