


console.log("contact.js 読み込まれました");


//リアルタイムバリデーション

document.addEventListener('DOMContentLoaded', () => {
    // お名前バリデーション
    const nameInput = document.forms['form']?.elements['name'];
    if (nameInput) {
        nameInput.addEventListener('input', () => {
            let error = nameInput.parentElement.querySelector('.error-msg');
            if (error) error.remove();

            const value = nameInput.value;

            // 空欄チェック
            if (value === '') {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'お名前は必須です。';
                nameInput.parentElement.appendChild(err);
                return;
            }

            // スペースのみ禁止
            if (/^[\s　]+$/.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'お名前は漢字・ひらがな・カタカナのみ、または姓と名の間にスペース1つで入力してください。';
                nameInput.parentElement.appendChild(err);
                return;
            }

            // 前後スペース禁止（間のスペースは許容）
            if (/^[\s　]/.test(value) || /[\s　]$/.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'お名前は漢字・ひらがな・カタカナのみ、または姓と名の間にスペース1つで入力してください。';
                nameInput.parentElement.appendChild(err);
                return;
            }

            // 漢字・ひらがな・カタカナのみ、または姓と名の間にスペース1つ（スペースなしも許容）
            const validRegex = /^([\u4E00-\u9FFF\u3040-\u309F\u30A0-\u30FF]+)([\s　]{1}[\u4E00-\u9FFF\u3040-\u309F\u30A0-\u30FF]+)?$/;
            if (!validRegex.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'お名前は漢字・ひらがな・カタカナのみ、または姓と名の間にスペース1つで入力してください。';
                nameInput.parentElement.appendChild(err);
            }
        });
    }



    // ふりがなバリデーション
    const kanaInput = document.forms['form']?.elements['kana'];
    if (kanaInput) {
        kanaInput.addEventListener('input', () => {
            let error = kanaInput.parentElement.querySelector('.error-msg');
            if (error) error.remove();

            const value = kanaInput.value;

            // 空欄チェック
            if (value === '') {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'ふりがなは必須です。';
                kanaInput.parentElement.appendChild(err);
                return;
            }

            // スペースのみ禁止
            if (/^[\s　]+$/.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'ふりがなは必須です。';
                kanaInput.parentElement.appendChild(err);
                return;
            }

            // 前後スペース禁止（間のスペースは許容）
            if (/^[\s　]/.test(value) || /[\s　]$/.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'ふりがなはひらがなのみで入力してください。';
                kanaInput.parentElement.appendChild(err);
                return;
            }

            // ひらがなのみ、または姓と名の間にスペース1つ（スペースなしも許容）
            const kanaRegex = /^([ぁ-んー]+)([\s　]{1}[ぁ-んー]+)?$/;
            if (!kanaRegex.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'ふりがなはひらがなのみで入力してください。';
                kanaInput.parentElement.appendChild(err);
            }
        });
    }

    // メールアドレスバリデーション
    const emailInput = document.forms['form']?.elements['email'];
    if (emailInput) {
        emailInput.addEventListener('input', () => {
            let error = emailInput.parentElement.querySelector('.error-msg');
            if (error) error.remove();

            const value = emailInput.value.trim();

            // 空欄チェック
            if (value === '') {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = 'メールアドレスは必須です。';
                emailInput.parentElement.appendChild(err);
                return;
            }
            // 入力途中でも形式になるまではエラー表示
            if (!validateMail(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = '有効なメールアドレスを入力してください。';
                emailInput.parentElement.appendChild(err);
            }

            function validateMail(val) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
            }
        });
    }

    // 郵便番号バリデーション
    const postalInput = document.forms['form']?.elements['postal_code'];
    if (postalInput) {
        postalInput.addEventListener('input', () => {
            let error = postalInput.parentElement.querySelector('.error-msg2');
            if (error) error.remove();

            if (!/^\d{3}-\d{4}$/.test(postalInput.value)) {
                const err = document.createElement('div');
                err.className = 'error-msg2';
                err.textContent = '郵便番号は「000-0000」の形式で入力してください。';
                postalInput.parentElement.appendChild(err);
            }
        });
    }

    // 電話番号バリデーション
    const telInput = document.forms['form']?.elements['tel'];
    if (telInput) {
        telInput.addEventListener('input', () => {
            let error = telInput.parentElement.querySelector('.error-msg');
            if (error) error.remove();

            const value = telInput.value;

            // 空欄チェック
            if (value.trim() === '') {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = '電話番号は必須です。';
                telInput.parentElement.appendChild(err);
                return;
            }

            // 入力途中でも形式になるまではエラー表示
            const telRegex = /^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/;
            if (!telRegex.test(value)) {
                const err = document.createElement('div');
                err.className = 'error-msg';
                err.textContent = '電話番号はハイフン(-)を2つ含めて12~13桁で正しく入力してください。';
                telInput.parentElement.appendChild(err);
            }
        });
    }
});

// 既存のvalidateMail, validateTel, validateKana関数はそのまま利用できます