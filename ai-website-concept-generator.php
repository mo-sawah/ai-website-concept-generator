<?php
/**
 * Plugin Name: AI Website Concept Generator
 * Description: Generate detailed website concepts and wireframes using AI, with optional demo generation
 * Version: 1.0.1
 * Author: Mohamed Sawah
 * Text Domain: ai-website-concept-generator
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('AIWCG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AIWCG_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('AIWCG_VERSION', '1.0.0');

class AIWebsiteConceptGenerator {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
    }
    
    public function init() {
        // Hook into WordPress
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_generate_concept', array($this, 'handle_generate_concept'));
        add_action('wp_ajax_nopriv_generate_concept', array($this, 'handle_generate_concept'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        
        // Register shortcode
        add_shortcode('ai_website_generator', array($this, 'render_shortcode'));
        
        // Debug: Add admin notice to confirm plugin is loaded
        add_action('admin_notices', array($this, 'debug_admin_notice'));
    }
    
    public function debug_admin_notice() {
        if (current_user_can('manage_options')) {
            echo '<div class="notice notice-info is-dismissible">';
            echo '<p>AI Website Concept Generator plugin is active. Use shortcode: [ai_website_generator]</p>';
            echo '</div>';
        }
    }
    
    public function enqueue_scripts() {
        // Only enqueue on pages with the shortcode
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'ai_website_generator')) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('aiwcg-main', AIWCG_PLUGIN_URL . 'assets/js/main.js', array('jquery'), AIWCG_VERSION, true);
            wp_enqueue_style('aiwcg-style', AIWCG_PLUGIN_URL . 'assets/css/style.css', array(), AIWCG_VERSION);
            
            wp_localize_script('aiwcg-main', 'aiwcg_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('aiwcg_nonce')
            ));
        }
    }
    
    public function add_admin_menu() {
        add_options_page(
            'AI Website Generator Settings',
            'AI Website Generator',
            'manage_options',
            'ai-website-generator',
            array($this, 'admin_page')
        );
    }
    
    public function admin_init() {
        register_setting('aiwcg_settings', 'aiwcg_openai_api_key');
        register_setting('aiwcg_settings', 'aiwcg_openrouter_api_key');
        register_setting('aiwcg_settings', 'aiwcg_default_provider');
        register_setting('aiwcg_settings', 'aiwcg_openai_model');
        register_setting('aiwcg_settings', 'aiwcg_openrouter_model');
        
        add_settings_section(
            'aiwcg_api_settings',
            'API Configuration',
            array($this, 'api_settings_callback'),
            'aiwcg_settings'
        );
        
        add_settings_field(
            'aiwcg_openai_api_key',
            'OpenAI API Key',
            array($this, 'openai_api_key_callback'),
            'aiwcg_settings',
            'aiwcg_api_settings'
        );
        
        add_settings_field(
            'aiwcg_openrouter_api_key',
            'OpenRouter API Key',
            array($this, 'openrouter_api_key_callback'),
            'aiwcg_settings',
            'aiwcg_api_settings'
        );
        
        add_settings_field(
            'aiwcg_default_provider',
            'Default AI Provider',
            array($this, 'default_provider_callback'),
            'aiwcg_settings',
            'aiwcg_api_settings'
        );
        
        add_settings_field(
            'aiwcg_openai_model',
            'OpenAI Model',
            array($this, 'openai_model_callback'),
            'aiwcg_settings',
            'aiwcg_api_settings'
        );
        
        add_settings_field(
            'aiwcg_openrouter_model',
            'OpenRouter Model',
            array($this, 'openrouter_model_callback'),
            'aiwcg_settings',
            'aiwcg_api_settings'
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>AI Website Generator Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('aiwcg_settings');
                do_settings_sections('aiwcg_settings');
                submit_button();
                ?>
            </form>
            
            <div class="card" style="margin-top: 20px; padding: 20px;">
                <h2>Usage Instructions</h2>
                <p>To display the AI Website Generator form on any page or post, use the shortcode:</p>
                <code style="background: #f1f1f1; padding: 5px; border-radius: 3px;">[ai_website_generator]</code>
                
                <h3>API Keys Setup:</h3>
                <ul>
                    <li><strong>OpenAI:</strong> Get your API key from <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI Platform</a></li>
                    <li><strong>OpenRouter:</strong> Get your API key from <a href="https://openrouter.ai/keys" target="_blank">OpenRouter</a></li>
                </ul>
                
                <h3>Recommended Models:</h3>
                <ul>
                    <li><strong>OpenAI:</strong> gpt-4 or gpt-4-turbo</li>
                    <li><strong>OpenRouter:</strong> anthropic/claude-3-opus or openai/gpt-4</li>
                </ul>
                
                <h3>Debug Info:</h3>
                <p><strong>Plugin Path:</strong> <?php echo AIWCG_PLUGIN_PATH; ?></p>
                <p><strong>Plugin URL:</strong> <?php echo AIWCG_PLUGIN_URL; ?></p>
                <p><strong>Template File Exists:</strong> <?php echo file_exists(AIWCG_PLUGIN_PATH . 'templates/generator-form.php') ? 'Yes' : 'No'; ?></p>
            </div>
        </div>
        <?php
    }
    
    public function api_settings_callback() {
        echo '<p>Configure your AI API keys and models for generating website concepts.</p>';
    }
    
    public function openai_api_key_callback() {
        $value = get_option('aiwcg_openai_api_key', '');
        echo '<input type="password" name="aiwcg_openai_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">Your OpenAI API key</p>';
    }
    
    public function openrouter_api_key_callback() {
        $value = get_option('aiwcg_openrouter_api_key', '');
        echo '<input type="password" name="aiwcg_openrouter_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">Your OpenRouter API key</p>';
    }
    
    public function default_provider_callback() {
        $value = get_option('aiwcg_default_provider', 'openai');
        echo '<select name="aiwcg_default_provider">';
        echo '<option value="openai"' . selected($value, 'openai', false) . '>OpenAI</option>';
        echo '<option value="openrouter"' . selected($value, 'openrouter', false) . '>OpenRouter</option>';
        echo '</select>';
        echo '<p class="description">Choose your preferred AI provider</p>';
    }
    
    public function openai_model_callback() {
        $value = get_option('aiwcg_openai_model', 'gpt-4');
        echo '<select name="aiwcg_openai_model">';
        echo '<option value="gpt-4"' . selected($value, 'gpt-4', false) . '>GPT-4</option>';
        echo '<option value="gpt-4-turbo"' . selected($value, 'gpt-4-turbo', false) . '>GPT-4 Turbo</option>';
        echo '<option value="gpt-3.5-turbo"' . selected($value, 'gpt-3.5-turbo', false) . '>GPT-3.5 Turbo</option>';
        echo '</select>';
    }
    
    public function openrouter_model_callback() {
        $value = get_option('aiwcg_openrouter_model', 'anthropic/claude-3-opus');
        echo '<select name="aiwcg_openrouter_model">';
        echo '<option value="anthropic/claude-3-opus"' . selected($value, 'anthropic/claude-3-opus', false) . '>Claude 3 Opus</option>';
        echo '<option value="anthropic/claude-3-sonnet"' . selected($value, 'anthropic/claude-3-sonnet', false) . '>Claude 3 Sonnet</option>';
        echo '<option value="openai/gpt-4"' . selected($value, 'openai/gpt-4', false) . '>GPT-4 (via OpenRouter)</option>';
        echo '<option value="meta-llama/llama-3-70b-instruct"' . selected($value, 'meta-llama/llama-3-70b-instruct', false) . '>Llama 3 70B</option>';
        echo '</select>';
    }
    
    public function render_shortcode($atts) {
        $atts = shortcode_atts(array(
            'style' => 'default'
        ), $atts);
        
        // Check if template file exists
        $template_path = AIWCG_PLUGIN_PATH . 'templates/generator-form.php';
        if (!file_exists($template_path)) {
            return '<div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">Template file not found: ' . $template_path . '</div>';
        }
        
        ob_start();
        include $template_path;
        return ob_get_clean();
    }
    
    public function handle_generate_concept() {
        check_ajax_referer('aiwcg_nonce', 'nonce');
        
        $form_data = json_decode(stripslashes($_POST['form_data']), true);
        
        try {
            $concept = $this->generate_ai_concept($form_data);
            wp_send_json_success($concept);
        } catch (Exception $e) {
            wp_send_json_error('Failed to generate concept: ' . $e->getMessage());
        }
    }
    
    private function generate_ai_concept($form_data) {
        $provider = get_option('aiwcg_default_provider', 'openai');
        
        if ($provider === 'openai') {
            return $this->generate_openai_concept($form_data);
        } else {
            return $this->generate_openrouter_concept($form_data);
        }
    }
    
    private function generate_openai_concept($form_data) {
        $api_key = get_option('aiwcg_openai_api_key');
        $model = get_option('aiwcg_openai_model', 'gpt-4');
        
        if (empty($api_key)) {
            throw new Exception('OpenAI API key not configured');
        }
        
        $prompt = $this->build_enhanced_prompt($form_data);
        
        $data = array(
            'model' => $model,
            'messages' => array(
                array(
                    'role' => 'system',
                    'content' => 'You are a senior web development consultant and UX/UI designer with 15+ years of experience. You create comprehensive, detailed website concepts with accurate technical specifications, realistic cost estimates, and detailed wireframes. Always respond with valid JSON only.'
                ),
                array(
                    'role' => 'user',
                    'content' => $prompt
                )
            ),
            'max_tokens' => 4000,
            'temperature' => 0.3
        );
        
        $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data),
            'timeout' => 60
        ));
        
        if (is_wp_error($response)) {
            throw new Exception('API request failed: ' . $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (!isset($result['choices'][0]['message']['content'])) {
            throw new Exception('Invalid API response');
        }
        
        $ai_response = trim($result['choices'][0]['message']['content']);
        $ai_response = preg_replace('/```json\s*/', '', $ai_response);
        $ai_response = preg_replace('/```\s*$/', '', $ai_response);
        
        $concept_data = json_decode($ai_response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from AI');
        }
        
        return $concept_data;
    }
    
    private function generate_openrouter_concept($form_data) {
        $api_key = get_option('aiwcg_openrouter_api_key');
        $model = get_option('aiwcg_openrouter_model', 'anthropic/claude-3-opus');
        
        if (empty($api_key)) {
            throw new Exception('OpenRouter API key not configured');
        }
        
        $prompt = $this->build_enhanced_prompt($form_data);
        
        $data = array(
            'model' => $model,
            'messages' => array(
                array(
                    'role' => 'system',
                    'content' => 'You are a senior web development consultant and UX/UI designer with 15+ years of experience. You create comprehensive, detailed website concepts with accurate technical specifications, realistic cost estimates, and detailed wireframes. Always respond with valid JSON only.'
                ),
                array(
                    'role' => 'user',
                    'content' => $prompt
                )
            ),
            'max_tokens' => 4000,
            'temperature' => 0.3
        );
        
        $response = wp_remote_post('https://openrouter.ai/api/v1/chat/completions', array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
                'HTTP-Referer' => home_url(),
                'X-Title' => get_bloginfo('name') . ' - AI Website Generator'
            ),
            'body' => json_encode($data),
            'timeout' => 60
        ));
        
        if (is_wp_error($response)) {
            throw new Exception('API request failed: ' . $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $result = json_decode($body, true);
        
        if (!isset($result['choices'][0]['message']['content'])) {
            throw new Exception('Invalid API response');
        }
        
        $ai_response = trim($result['choices'][0]['message']['content']);
        $ai_response = preg_replace('/```json\s*/', '', $ai_response);
        $ai_response = preg_replace('/```\s*$/', '', $ai_response);
        
        $concept_data = json_decode($ai_response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from AI');
        }
        
        return $concept_data;
    }
    
    private function build_enhanced_prompt($form_data) {
        $features_text = is_array($form_data['features']) ? implode(', ', $form_data['features']) : '';
        
        return "You are a senior web development consultant. Create a comprehensive website concept based on these requirements:

BUSINESS INFORMATION:
- Business: {$form_data['businessType']}
- Industry: {$form_data['industry']}
- Company Size: {$form_data['companySize']}
- Target Audience: {$form_data['targetAudience']}
- Primary Goal: {$form_data['businessGoal']}
- Budget: {$form_data['budget']}
- Website Type: {$form_data['websiteType']}
- Design Style: {$form_data['designStyle']}
- Current Status: {$form_data['currentWebsite']}
- Timeline: {$form_data['timeline']}
- Features Needed: {$features_text}
- Description: {$form_data['businessDescription']}

RESPOND WITH THIS EXACT JSON STRUCTURE:
{
  \"concept\": {
    \"title\": \"[Business name with professional tagline]\",
    \"tagline\": \"[Compelling 5-8 word tagline specific to industry]\",
    \"description\": \"[Detailed 3-4 sentence description of the website concept]\",
    \"estimatedCost\": \"[Realistic range like '$8,500 - $15,000']\",
    \"timeline\": \"[Realistic timeline like '8-12 weeks']\",
    \"pages\": \"[Number like 8-15]\",
    \"sections\": [
      \"Header Navigation\",
      \"Hero Section\",
      \"Services Overview\",
      \"About Company\",
      \"Testimonials\",
      \"Contact Information\"
    ]
  },
  \"wireframes\": {
    \"homepage\": {
      \"sections\": [
        {\"name\": \"Header\", \"height\": 80, \"color\": \"#1e293b\", \"description\": \"Logo and navigation\"},
        {\"name\": \"Hero Section\", \"height\": 600, \"color\": \"#3b82f6\", \"description\": \"Main headline and CTA\"},
        {\"name\": \"Services\", \"height\": 400, \"color\": \"#f8fafc\", \"description\": \"Service offerings\"},
        {\"name\": \"About\", \"height\": 350, \"color\": \"#e2e8f0\", \"description\": \"Company information\"},
        {\"name\": \"Contact\", \"height\": 300, \"color\": \"#1e40af\", \"description\": \"Contact form\"},
        {\"name\": \"Footer\", \"height\": 200, \"color\": \"#0f172a\", \"description\": \"Links and info\"}
      ]
    }
  },
  \"colorScheme\": {
    \"primary\": \"#3b82f6\",
    \"secondary\": \"#8b5cf6\", 
    \"accent\": \"#f59e0b\",
    \"background\": \"#ffffff\",
    \"text\": \"#1f2937\"
  },
  \"features\": {
    \"essential\": [\"Contact Forms\", \"Mobile Responsive\", \"SEO Optimization\"],
    \"recommended\": [\"Live Chat\", \"Analytics\", \"Social Integration\"],
    \"advanced\": [\"CRM Integration\", \"Automation\"]
  },
  \"performance\": {
    \"seoScore\": \"92\",
    \"performanceScore\": \"88\",
    \"accessibilityScore\": \"95\",
    \"mobileScore\": \"94\"
  }
}";
    }
}

// Initialize the plugin
AIWebsiteConceptGenerator::get_instance();