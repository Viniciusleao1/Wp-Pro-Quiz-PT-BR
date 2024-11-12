<?php

class WpProQuiz_View_WpqSupport extends WpProQuiz_View_View
{

    public function show()
    {
        ?>

        <div class="wrap">
            <h2><?php _e('Apoiar Wp-Pro-Quiz-PT-BR', 'wp-pro-quiz'); ?></h2>

            <h3><?php _e('Doar', 'wp-pro-quiz'); ?></h3>

            <a class="button" style="background-color: #ffb735;font-weight: bold;" target="_blank" href="https://buy.stripe.com/8wM03O9Hj3Rw7oA7ss"><?php _e('Doação Stripe', 'wp-pro-quiz'); ?></a>

            <p>
                <?php _e('WP-Pro-Quiz é um pequeno, mas bom plugin de teste gratuito para WordPress.', 'wp-pro-quiz'); ?> <br>
                <?php _e('Tento implementar todos os desejos o mais rápido possível e ajudar com os problemas.', 'wp-pro-quiz'); ?>
                <br>
                <?php _e('Suas doações podem ajudar a garantir que o projeto continue gratuito.',
                    'wp-pro-quiz'); ?>
            </p>

            <h3>Wp-Pro-Quiz-PT-BR no Github</h3>

            <a class="button" target="_blank" href="https://github.com/Viniciusleao1/Wp-Pro-Quiz-PT-BR"><?php _e('Wp-Pro-Quiz-PT-BR no Github', 'wp-pro-quiz'); ?></a>


            <h3><?php _e('WP-Pro-Quiz modificação especial', 'wp-pro-quiz'); ?></h3>
            <strong><?php _e('Você precisa de uma modificação especial do WP-Pro-Quiz para seu site?',
                    'wp-pro-quiz'); ?></strong><br>
            <a class="button-primary" href="admin.php?page=wpProQuiz&module=info_adaptation"
               style="margin-top: 5px;"><?php _e('Saber mais', 'wp-pro-quiz'); ?></a>

            <h3>Wp-Pro-Quiz Wiki</h3>

            <a class="button-primary" target="_blank" href="https://github.com/xeno010/Wp-Pro-Quiz/wiki">--> Wiki <--</a>

            <h3 style="margin-top: 40px;"><?php _e('Traduzir WP-Pro-Quiz', 'wp-pro-quiz'); ?></h3>

            <p>
                <?php _e('Para traduzir o wp-pro-quiz, siga estes passos:', 'wp-pro-quiz'); ?>
            </p>

            <ul style="list-style: decimal; padding: 0 22px;">
    <li><?php _e('Entre na sua conta no wordpress.org (ou crie uma conta se ainda não tiver uma).', 'wp-pro-quiz'); ?></li>
    <li><?php _e('Acesse <a href="https://translate.wordpress.org" target="_blank">https://translate.wordpress.org</a>.', 'wp-pro-quiz'); ?></li>
    <li><?php _e('Selecione seu idioma e clique em “Contribuir com tradução”.', 'wp-pro-quiz'); ?></li>
    <li><?php _e('Vá até a aba Plugins e procure por “Wp-Pro-Quiz”.', 'wp-pro-quiz'); ?></li>
    <li><?php _e('Selecione o plugin e comece a traduzir!', 'wp-pro-quiz'); ?></li>
    <li>
    <?php _e('Agradecimentos especiais: Este plugin foi carinhosamente traduzido para Português (BR) pelo desenvolvedor <strong>Vinicius Leão</strong>, contribuidor ativo em <a href="https://translate.wordpress.org" target="_blank">traduções no WordPress</a>.', 'wp-pro-quiz'); ?>
    
<?php _e('Se desejar apoiar o desenvolvedor, considere fazer uma doação via Stripe:', 'wp-pro-quiz'); ?>
    <a class="button" style="background-color: #ffb735;font-weight: bold;display:inline-block;margin-left:10px;" target="_blank" href="https://buy.stripe.com/8wM03O9Hj3Rw7oA7ss"><?php _e('Doar', 'wp-pro-quiz'); ?></a>
</li>
</ul>


        </div>

        <?php
    }
}
