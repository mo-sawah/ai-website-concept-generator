<?php
/**
 * Plugin Name: AI Website Concept Generator
 * Description: Generate detailed website concepts and wireframes using AI, with optional demo generation
 * Version: 1.0.0
 * Author: Mohamed Sawah
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
    
    public function __init() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_generate_concept', array($this, 'handle_generate_concept'));
        add_action('wp_ajax_nopriv_generate_concept', array($this, 'handle_generate_concept'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        
        // Register shortcode
        add_shortcode('ai_website_generator', array($this, 'render_shortcode'));
    }
    
    public function init() {
        // Plugin initialization
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('aiwcg-main', AIWCG_PLUGIN_URL . 'assets/js/main.js', array('jquery'), AIWCG_VERSION, true);
        wp_enqueue_style('aiwcg-style', AIWCG_PLUGIN_URL . 'assets/css/style.css', array(), AIWCG_VERSION);
        
        wp_localize_script('aiwcg-main', 'aiwcg_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aiwcg_nonce')
        ));
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
            
            <div class="card" style="margin-top: 20px;">
                <h2>Usage Instructions</h2>
                <p>To display the AI Website Generator form on any page or post, use the shortcode:</p>
                <code>[ai_website_generator]</code>
                
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
        
        ob_start();
        include AIWCG_PLUGIN_PATH . 'templates/generator-form.php';
        return ob_get_clean();
    }
    
    public function handle_generate_concept() {
        check_ajax_referer('aiwcg_nonce', 'nonce');
        
        $form_data = $_POST['form_data'];
        
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

REQUIREMENTS:
1. Provide realistic cost estimates based on complexity and features
2. Create detailed wireframes with proper sections and layouts
3. Include technical specifications and performance metrics
4. Suggest appropriate technology stack
5. Provide content strategy recommendations
6. Include SEO and marketing considerations

RESPOND WITH THIS EXACT JSON STRUCTURE:
{
  \"concept\": {
    \"title\": \"[Business name with professional tagline]\",
    \"tagline\": \"[Compelling 5-8 word tagline specific to industry]\",
    \"description\": \"[Detailed 3-4 sentence description of the website concept, focusing on user experience and business goals]\",
    \"estimatedCost\": \"[Realistic range like '$8,500 - $15,000' based on complexity]\",
    \"timeline\": \"[Realistic timeline like '8-12 weeks']\",
    \"pages\": \"[Number like 8-15 based on requirements]\",
    \"sections\": [
      \"[5-7 specific sections relevant to the business type]\"
    ],
    \"technologyStack\": [
      \"[4-6 technologies like 'React.js', 'Node.js', 'PostgreSQL']\"
    ],
    \"contentStrategy\": \"[2-3 sentences about content approach and requirements]\",
    \"seoStrategy\": \"[2-3 sentences about SEO approach and expected outcomes]\"
  },
  \"wireframes\": {
    \"homepage\": {
      \"sections\": [
        {\"name\": \"Header with Navigation\", \"height\": 80, \"color\": \"#1e293b\", \"description\": \"Logo, main navigation, CTA button\"},
        {\"name\": \"Hero Section\", \"height\": 600, \"color\": \"#3b82f6\", \"description\": \"[Specific hero content for this business]\"},
        {\"name\": \"[Business-specific section]\", \"height\": 400, \"color\": \"#f8fafc\", \"description\": \"[Detailed description]\"},
        {\"name\": \"[Another relevant section]\", \"height\": 350, \"color\": \"#e2e8f0\", \"description\": \"[Detailed description]\"},
        {\"name\": \"[CTA or Contact section]\", \"height\": 300, \"color\": \"#1e40af\", \"description\": \"[Detailed description]\"},
        {\"name\": \"Footer\", \"height\": 200, \"color\": \"#0f172a\", \"description\": \"Links, contact info, social media\"}
      ]
    },
    \"additionalPages\": [
      {
        \"name\": \"[Relevant page like 'Services' or 'About']\",
        \"purpose\": \"[Why this page is important]\",
        \"keyElements\": [\"[3-4 key elements for this page]\"]
      },
      {
        \"name\": \"[Another relevant page]\",
        \"purpose\": \"[Purpose description]\",
        \"keyElements\": [\"[3-4 key elements]\"]
      }
    ]
  },
  \"colorScheme\": {
    \"primary\": \"[Color that matches industry - hex code]\",
    \"secondary\": \"[Complementary color - hex code]\", 
    \"accent\": \"[Accent color - hex code]\",
    \"background\": \"[Background color - hex code]\",
    \"text\": \"[Text color - hex code]\",
    \"rationale\": \"[1-2 sentences explaining color choices for this industry]\"
  },
  \"features\": {
    \"essential\": [\"[4-5 essential features specific to this business type]\"],
    \"recommended\": [\"[3-4 recommended features that add value]\"],
    \"advanced\": [\"[2-3 advanced features for future growth]\"],
    \"integrations\": [\"[3-4 third-party integrations that would benefit this business]\"]
  },
  \"performance\": {
    \"seoScore\": \"[85-98 based on planned optimizations]\",
    \"performanceScore\": \"[85-95 based on technical approach]\",
    \"accessibilityScore\": \"[90-99 based on accessibility features]\",
    \"mobileScore\": \"[90-99 based on responsive design approach]\"
  },
  \"contentRequirements\": {
    \"copywritingPages\": \"[Number of pages needing professional copy]\",
    \"photographyNeeds\": \"[Description of photo requirements]\",
    \"videoContent\": \"[Video content recommendations]\",
    \"estimatedContentCost\": \"[Additional cost for content creation]\"
  },
  \"maintenanceAndSupport\": {
    \"monthlyMaintenance\": \"[Monthly cost estimate like '$150-300']\",
    \"hostingRecommendation\": \"[Specific hosting recommendation]\",
    \"securityFeatures\": [\"[3-4 security measures]\"],
    \"backupStrategy\": \"[Backup approach description]\"
  },
  \"projectPhases\": [
    {
      \"phase\": \"Planning & Design\",
      \"duration\": \"[Duration like '2-3 weeks']\",
      \"deliverables\": [\"[3-4 specific deliverables]\"]
    },
    {
      \"phase\": \"Development\",
      \"duration\": \"[Duration]\",
      \"deliverables\": [\"[3-4 deliverables]\"]
    },
    {
      \"phase\": \"Testing & Launch\",
      \"duration\": \"[Duration]\",
      \"deliverables\": [\"[3-4 deliverables]\"]
    }
  ]
}

Make everything specific to the {$form_data['businessType']} in the {$form_data['industry']} industry. Ensure all recommendations are practical and industry-appropriate.";
    }
}

// Initialize the plugin
new AIWebsiteConceptGenerator();