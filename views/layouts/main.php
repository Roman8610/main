<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use app\widgets\ChatWidget;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<!-- Подключаем FontAwesome через CDN -->

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                ['label' => 'Meetings', 'url' => ['/Qm/meetings']],
                Yii::$app->user->isGuest
                    ? ['label' => 'Login', 'url' => ['/site/login']]
                    : '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ]
        ]);
        echo Html::button('Скрыть чат', [
            'id' => 'sidebar-chat-toggle',
            'class' => 'btn btn-outline-light ms-auto',
            'type' => 'button',
            'aria-controls' => 'sidebar-chat',
            'aria-expanded' => 'true',
        ]);
        NavBar::end();
        ?>
    </header>

    <style>
        body {
            padding-top: 0;
        }

        .sidebar-chat {
            position: fixed;
            top: 0;
            right: 0;
            width: 30vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            z-index: 1020;
            overflow-y: auto;
            padding: 1rem;
            border: 1px solid #d3d3d3;
            border-radius: 8px;
        }

        .sidebar-chat-form {
            width: 100%;
            margin-top: auto;
        }

        .sidebar-chat-dialog {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .sidebar-chat-message {
            max-width: 85%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.75rem;
            overflow-wrap: anywhere;
        }

        .sidebar-chat-message-incoming {
            align-self: flex-start;
            background: #f1f3f5;
        }

        .sidebar-chat-message-outgoing {
            align-self: flex-end;
            background: #dbeafe;
        }

        body.chat-hidden .sidebar-chat {
            display: none;
        }

        .page-content {
            display: flex;
            flex-direction: column;
            width: calc(100vw - 30vw);
            max-width: calc(100vw - 30vw);
            min-height: 100vh;
            box-sizing: border-box;
            padding-top: 72px;
            padding-right: 1.5rem;
        }

        #header .navbar {
            width: calc(100vw - 31vw);
        }

        body.chat-hidden .page-content {
            width: 100vw;
            max-width: 100vw;
            padding-right: 0;
        }

        body.chat-hidden #header .navbar {
            width: 100vw;
        }

        .page-content main {
            flex-grow: 1;
        }

        .page-content .container {
            width: 100%;
            max-width: none;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        </style>

    <aside id="sidebar-chat" class="sidebar-chat" aria-label="Чат">
        <?= ChatWidget::widget() ?>
    </aside>

    <div class="page-content">
        <main id="main" class="flex-shrink-0" role="main">
            <div class="container">
                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success" style="scroll-margin-top: 80px">
                        <?= Yii::$app->session->getFlash('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($this->params['breadcrumbs'])): ?>
                    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
                <?php endif ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </main>

        <footer id="footer" class="mt-auto py-3 bg-light">
            <div class="container">
                <div class="row text-muted">
                    <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                    <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
                </div>
            </div>
        </footer>
    </div>

    <?php
    $this->registerJs(<<<'JS'
        const chatToggle = document.getElementById('sidebar-chat-toggle');
        const chatPanel = document.getElementById('sidebar-chat');

        chatToggle.addEventListener('click', () => {
            const isHidden = document.body.classList.toggle('chat-hidden');
            chatToggle.textContent = isHidden ? 'Показать чат' : 'Скрыть чат';
            chatToggle.setAttribute('aria-expanded', String(!isHidden));
            chatPanel.setAttribute('aria-hidden', String(isHidden));
        });
    JS);
    ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>