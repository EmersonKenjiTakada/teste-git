<?php

namespace Includes\Core;

class Core
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'adicionarPaginaConfiguracoes'));
        add_action('admin_init', array($this, 'inicializarConfiguracoes'));
    }

    public function adicionarPaginaConfiguracoes()
    {
        add_menu_page(
            'Configurações do Meu Plugin',
            'Meu Plugin',
            'manage_options',
            'meu-plugin-config',
            array($this, 'paginaConfiguracoes')
        );
    }

    public function paginaConfiguracoes()
    {
?>
        <div class="wrap">
            <h1>Configurações do Meu Plugin</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('meu_plugin_opcoes');
                do_settings_sections('meu_plugin_config');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }

    public function inicializarConfiguracoes()
    {
        // Seção de configuração
        add_settings_section(
            'meu_plugin_secao',
            'Configurações Gerais',
            array($this, 'secaoDescricao'),
            'meu_plugin_config'
        );

        // Campo de checkbox
        add_settings_field(
            'lnd_checkbox_field_version',
            'Verificação de versionamento',
            array($this, 'campoCheckbox'),
            'meu_plugin_config',
            'meu_plugin_secao',
            array('label_for' => 'lnd_checkbox_field_version')
        );

        register_setting('meu_plugin_opcoes', 'meu_plugin_opcoes', array($this, 'validarOpcoes'));
    }

    public function secaoDescricao()
    {
        echo '<p>Configurações gerais para o Meu Plugin.</p>';
    }

    public function campoCheckbox()
    {
        $options = get_option('meu_plugin_opcoes');
        $checked = isset($options['lnd_checkbox_field_version']) && $options['lnd_checkbox_field_version'] === 'on' ? 'checked' : '';
        echo '<input type="checkbox" class="ikxBAC" id="lnd_checkbox_field_version" name="meu_plugin_opcoes[lnd_checkbox_field_version]" ' . $checked . '>';
        echo '<label for="lnd_checkbox_field_version">Desativa controle verificação de versionamento</label>';
    }

    public function validarOpcoes($input)
    {
        // Aqui você pode adicionar lógica de validação se necessário
        return $input;
    }
}
