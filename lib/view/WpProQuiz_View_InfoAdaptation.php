<?php

class WpProQuiz_View_InfoAdaptation extends WpProQuiz_View_View
{
    public function show()
    {
        ?>

        <div class="wrap">
            <h2><?php _e('Modificação especial do WP-Pro-Quiz', 'wp-pro-quiz'); ?></h2>

            <p><?php _e('Você precisa de uma modificação especial do WP-Pro-Quiz para seu site?', 'wp-pro-quiz'); ?></p>

            <h3><?php _e('Nós oferecemos a você:', 'wp-pro-quiz'); ?></h3>
            <ol style="list-style-type: disc;">
                <li><?php _e('Adaptação de design para seu tema', 'wp-pro-quiz'); ?></li>
                <li><?php _e('Criação de módulos adicionais para suas necessidades', 'wp-pro-quiz'); ?></li>
                <li style="display: none;"><?php _e('Suporte Premium', 'wp-pro-quiz'); ?></li>
            </ol>

            <h3><?php _e('Contate-nos:', 'wp-pro-quiz'); ?></h3>
            <ol style="list-style-type: disc;">
                <li><?php _e('Envie-nos um e-mail', 'wp-pro-quiz'); ?> <a href="mailto:wp-pro-quiz@it-gecko.de"
                                                                        style="font-weight: bold;">wp-pro-quiz@it-gecko.de</a>
                </li>
                <li><?php _e('O e-mail deve ser escrito em inglês ou alemão', 'wp-pro-quiz'); ?></li>
                <li><?php _e('Explique seu desejo detalhadamente e da forma mais exata possível', 'wp-pro-quiz'); ?>
                    <ol style="list-style-type: disc;">
                        <li><?php _e('Você pode nos enviar capturas de tela, esboços e anexos', 'wp-pro-quiz'); ?></li>
                    </ol>
                </li>
                <li><?php _e('Envie-nos seu nome completo e seu endereço web (URL da página web)', 'wp-pro-quiz'); ?></li>
                <li><?php _e('Se você deseja adaptação de design, precisamos adicionalmente do nome do seu tema',
                        'wp-pro-quiz'); ?></li>
            </ol>

            <p>
                <?php _e('Após receber seu e-mail, verificaremos sua solicitação quanto à viabilidade. Depois disso, você receberá um e-mail nosso com mais detalhes e oferta.',
                    'wp-pro-quiz'); ?>
            </p>

            <p>
                <?php _e('Suporte estendido nos primeiros 6 meses. Bugs reportados e atualizações do WP Pro Quiz são suportados. Exceção são lançamentos principais (atualização da versão principal)',
                    'wp-pro-quiz'); ?>
            </p>
        </div>

        <?php
    }
}