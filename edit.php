<?php
require_once 'Db.php';
require_once 'User.php';
require_once 'Validator.php';

session_cache_limiter('none');
session_start();

$error_message = [];
$old = $_POST ?? [];

if (!empty($_POST)) {
    $validator = new Validator();
    if ($validator->validate($_POST)) {
        $_SESSION['edit_data'] = $_POST;
        header('Location: update.php');
        exit();
    } else {
        $error_message = $validator->getErrors();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = new User($pdo);
    $old = $user->findById($id);
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>mini System</title>
    <link rel="stylesheet" href="style_new.css">
    <script src="postalcodesearch.js"></script>
</head>

<body>
    <div>
        <h1>mini System</h1>
    </div>
    <div>
        <h2>更新画面</h2>
    </div>
    <div>
        <form action="edit.php" method="post" name="edit" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($old['id']) ?>">


            <h1 class="contact-title">更新内容入力</h1>
            <p>内容を修正し、「更新」ボタンをクリックしてください。</p>

            <div>
                <div>
                    <label>お名前<span>必須</span></label>
                    <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                    <?php if (isset($error_message['name'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['name']) ?></div>
                    <?php endif ?>
                </div>

                <div>
                    <label>ふりがな<span>必須</span></label>
                    <input type="text" name="kana" value="<?= htmlspecialchars($old['kana'] ?? '') ?>">
                    <?php if (isset($error_message['kana'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['kana']) ?></div>
                    <?php endif ?>
                </div>
                <div>
                    <label>性別<span>必須</span></label>
                    <?php $gender = $old['gender_flag'] ?? '1'; ?>
                    <label><input type="radio" name="gender_flag" value="1" <?= $gender == '1' ? 'checked' : '' ?>>男性</label>
                    <label><input type="radio" name="gender_flag" value="2" <?= $gender == '2' ? 'checked' : '' ?>>女性</label>
                    <label><input type="radio" name="gender_flag" value="3" <?= $gender == '3' ? 'checked' : '' ?>>その他</label>
                </div>

                <div>
                    <label>生年月日<span>必須</span></label>
                    <?php
                    $birth_year = $old['birth_year'] ?? '';
                    $birth_month = $old['birth_month'] ?? '';
                    $birth_day = $old['birth_day'] ?? '';
                    if (empty($birth_year) && !empty($old['birth_date'])) {
                        $parts = explode('-', $old['birth_date']);
                        $birth_year = $parts[0] ?? '';
                        $birth_month = $parts[1] ?? '';
                        $birth_day = $parts[2] ?? '';
                    }
                    $birth_disp = ($birth_year && $birth_month && $birth_day) ? sprintf('%04d-%02d-%02d', $birth_year, $birth_month, $birth_day) : '';
                    ?>
                    <input type="text" name="birth_date_disp" value="<?= htmlspecialchars($birth_disp) ?>" readonly class="readonly-field">
                    <input type="hidden" name="birth_year" value="<?= htmlspecialchars($birth_year) ?>">
                    <input type="hidden" name="birth_month" value="<?= htmlspecialchars($birth_month) ?>">
                    <input type="hidden" name="birth_day" value="<?= htmlspecialchars($birth_day) ?>">
                    <?php if (isset($error_message['birth_date'])) : ?>
                        <div class="error-msg"> <?= htmlspecialchars($error_message['birth_date']) ?> </div>
                    <?php endif ?>
                </div>

                <div>
                    <label>郵便番号<span>必須</span></label>
                    <input type="text" name="postal_code" value="<?= htmlspecialchars($old['postal_code'] ?? '') ?>">
                    <?php if (isset($error_message['postal_code'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['postal_code']) ?></div>
                    <?php endif ?>
                </div>

                <div>
                    <label>住所<span>必須</span></label>
                    <input type="text" name="prefecture" value="<?= htmlspecialchars($old['prefecture'] ?? '') ?>">
                    <input type="text" name="city_town" value="<?= htmlspecialchars($old['city_town'] ?? '') ?>">
                    <input type="text" name="building" value="<?= htmlspecialchars($old['building'] ?? '') ?>">
                    <?php if (isset($error_message['address'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['address']) ?></div>
                    <?php endif ?>
                </div>

                <div>
                    <label>電話番号<span>必須</span></label>
                    <input type="text" name="tel" value="<?= htmlspecialchars($old['tel'] ?? '') ?>">
                    <?php if (isset($error_message['tel'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['tel']) ?></div>
                    <?php endif ?>
                </div>

                <div>
                    <label>メールアドレス<span>必須</span></label>
                    <input type="text" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
                    <?php if (isset($error_message['email'])) : ?>
                        <div class="error-msg"><?= htmlspecialchars($error_message['email']) ?></div>
                    <?php endif ?>
                </div>
            </div>

            //137-151
            <div>
                <label for="document1">本人確認書類（表面）:</label>
                <input type="file" name="document1" id="document1">
                <?php if (!empty($error_message['document1'])): ?>
                    <p class="error"><?= htmlspecialchars($error_message['document1']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="document2">本人確認書類（裏面）:</label>
                <input type="file" name="document2" id="document2">
                <?php if (!empty($error_message['document2'])): ?>
                    <p class="error"><?= htmlspecialchars($error_message['document2']) ?></p>
                <?php endif; ?>
            </div>

            <button type="submit">更新</button>
            <a href="dashboard.php" class="btn">ダッシュボードに戻る</a>

        </form>

        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($old['id']) ?>">
            <button type="submit">削除</button>
        </form>
    </div>
</body>

</html>