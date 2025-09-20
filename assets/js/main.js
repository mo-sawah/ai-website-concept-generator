/**
 * AI Website Concept Generator - Main JavaScript
 * Handles form interactions and AJAX requests
 */

(function ($) {
  "use strict";

  // Form data object
  let formData = {
    businessType: "",
    industry: "",
    companySize: "",
    targetAudience: "",
    businessGoal: "",
    budget: "",
    businessDescription: "",
    timeline: "",
    currentWebsite: "",
    websiteType: "",
    designStyle: "",
    features: [],
  };

  $(document).ready(function () {
    initializePlugin();
  });

  function initializePlugin() {
    bindFormEvents();
    validateForm();
  }

  function bindFormEvents() {
    // Text input events
    $('[id^="aiwcg-"]')
      .filter('input[type="text"], textarea')
      .on("input", function () {
        const fieldName = this.id.replace("aiwcg-", "");
        formData[fieldName] = this.value;
        validateForm();
      });

    // Select events
    $('[id^="aiwcg-"]')
      .filter("select")
      .on("change", function () {
        const fieldName = this.id.replace("aiwcg-", "");
        formData[fieldName] = this.value;
        validateForm();
      });

    // Website type selection
    $(document).on("click", ".aiwcg-website-type", function () {
      $(".aiwcg-website-type").removeClass("selected");
      $(this).addClass("selected");
      formData.websiteType = $(this).data("value");
    });

    // Design style selection
    $(document).on("click", ".aiwcg-design-style", function () {
      $(".aiwcg-design-style").removeClass("selected");
      $(this).addClass("selected");
      formData.designStyle = $(this).data("value");
    });

    // Feature selection
    $(document).on("click", ".aiwcg-feature", function () {
      const value = $(this).data("value");
      const index = formData.features.indexOf(value);

      if (index > -1) {
        formData.features.splice(index, 1);
        $(this).removeClass("selected");
      } else {
        formData.features.push(value);
        $(this).addClass("selected");
      }
    });

    // Generate button
    $(document).on("click", "#aiwcg-generateBtn", function () {
      if (validateForm()) {
        generateConcept();
      }
    });
  }

  function validateForm() {
    const isValid = formData.businessType && formData.industry;
    const $validationMessage = $("#aiwcg-validation-message");
    const $generateBtn = $("#aiwcg-generateBtn");

    if (isValid) {
      $validationMessage.addClass("aiwcg-hidden");
      $generateBtn.prop("disabled", false).css("opacity", "1");
      return true;
    } else {
      $validationMessage.removeClass("aiwcg-hidden");
      $generateBtn.prop("disabled", true).css("opacity", "0.5");
      return false;
    }
  }

  async function generateConcept() {
    try {
      // Show loading state
      showLoadingState();

      // Animate progress steps
      await animateProgressSteps();

      // Make AJAX request
      const response = await makeAjaxRequest();

      // Handle response
      if (response.success) {
        displayResults(response.data);
      } else {
        throw new Error(response.data || "Generation failed");
      }
    } catch (error) {
      console.error("Error generating concept:", error);
      displayError(error.message);
    } finally {
      hideLoadingState();
    }
  }

  function showLoadingState() {
    $("#aiwcg-form-section").addClass("aiwcg-hidden");
    $("#aiwcg-loading-section").removeClass("aiwcg-hidden");
  }

  function hideLoadingState() {
    $("#aiwcg-loading-section").addClass("aiwcg-hidden");
    $("#aiwcg-results-section").removeClass("aiwcg-hidden");

    // Scroll to results
    $("html, body").animate(
      {
        scrollTop: $("#aiwcg-results-section").offset().top - 50,
      },
      800
    );
  }

  async function animateProgressSteps() {
    const $steps = $(".aiwcg-progress-step");

    for (let i = 0; i < $steps.length; i++) {
      await new Promise((resolve) => setTimeout(resolve, 800));

      const $step = $steps.eq(i);
      $step.addClass("active");

      // Update icon to checkmark
      $step.find("div:first div:first").html(`
                <svg style="width: 1rem; height: 1rem; margin-right: 0.75rem; color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            `);
    }
  }

  function makeAjaxRequest() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: aiwcg_ajax.ajax_url,
        type: "POST",
        data: {
          action: "generate_concept",
          nonce: aiwcg_ajax.nonce,
          form_data: JSON.stringify(formData),
        },
        timeout: 120000, // 2 minutes timeout
        success: function (response) {
          resolve(response);
        },
        error: function (xhr, status, error) {
          reject(new Error("Network error: " + error));
        },
      });
    });
  }

  function displayResults(data) {
    const resultsHtml = generateResultsHTML(data);
    $("#aiwcg-results-section").html(resultsHtml);
  }

  function generateResultsHTML(data) {
    return `
            <div class="aiwcg-results-header">
                <div class="aiwcg-success-icon">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Your AI-Generated Website Concept is Ready!</h2>
                <p style="font-size: 1.125rem; color: #d1d5db;">Complete with detailed wireframes, technical specifications, and cost projections</p>
            </div>

            <!-- Concept Overview -->
            <div class="aiwcg-glass" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(59, 130, 246, 0.2)); border: 1px solid rgba(124, 58, 237, 0.3);">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                    <div>
                        <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">${
                          data.concept.title
                        }</h2>
                        <p style="font-size: 1.25rem; color: #c4b5fd; font-weight: 500; margin-bottom: 1rem;">"${
                          data.concept.tagline
                        }"</p>
                    </div>
                    <button onclick="aiwcgResetGenerator()" style="padding: 0.75rem; background: rgba(55, 65, 81, 0.5); border: none; border-radius: 0.5rem; color: #d1d5db; cursor: pointer;" title="Generate New Concept">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                </div>
                
                <p style="font-size: 1.125rem; line-height: 1.7; margin-bottom: 2rem;">${
                  data.concept.description
                }</p>

                <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    <div class="aiwcg-metric-card">
                        <div class="aiwcg-metric-value" style="color: #22c55e;">${
                          data.concept.estimatedCost
                        }</div>
                        <div class="aiwcg-metric-label">Estimated Cost</div>
                    </div>
                    <div class="aiwcg-metric-card">
                        <div class="aiwcg-metric-value" style="color: #3b82f6;">${
                          data.concept.timeline
                        }</div>
                        <div class="aiwcg-metric-label">Timeline</div>
                    </div>
                    <div class="aiwcg-metric-card">
                        <div class="aiwcg-metric-value" style="color: #8b5cf6;">${
                          data.concept.pages
                        }</div>
                        <div class="aiwcg-metric-label">Pages</div>
                    </div>
                    <div class="aiwcg-metric-card">
                        <div class="aiwcg-metric-value" style="color: #f59e0b;">${
                          data.performance?.seoScore || "95"
                        }/100</div>
                        <div class="aiwcg-metric-label">SEO Score</div>
                    </div>
                </div>

                ${generateSectionsHTML(data.concept.sections)}
            </div>

            ${generateWireframesHTML(data.wireframes)}
            ${generateColorSchemeHTML(data.colorScheme)}
            ${generateFeaturesHTML(data.features)}
            ${generatePerformanceHTML(data.performance)}
            ${generateContentStrategyHTML(data.concept)}
            ${generateActionButtonsHTML()}
        `;
  }

  function generateSectionsHTML(sections) {
    if (!sections || !sections.length) return "";

    return `
            <div>
                <h4 style="font-weight: 600; margin-bottom: 1rem;">Recommended Website Sections:</h4>
                <div class="aiwcg-grid aiwcg-grid-2" style="gap: 0.75rem;">
                    ${sections
                      .map(
                        (section) => `
                        <div style="display: flex; align-items: center; color: #d1d5db;">
                            <div style="width: 0.5rem; height: 0.5rem; background: #8b5cf6; border-radius: 50%; margin-right: 0.75rem;"></div>
                            ${section}
                        </div>
                    `
                      )
                      .join("")}
                </div>
            </div>
        `;
  }

  function generateWireframesHTML(wireframes) {
    if (!wireframes || !wireframes.homepage) return "";

    return `
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Interactive Homepage Wireframe
                </h3>
                
                <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1.5rem; border: 1px solid rgba(255, 255, 255, 0.1);">
                    ${wireframes.homepage.sections
                      .map(
                        (section, index) => `
                        <div class="aiwcg-wireframe-section" 
                             style="height: ${Math.max(
                               section.height * 0.15,
                               35
                             )}px; background-color: ${
                          section.color
                        }; margin-bottom: 0.5rem; position: relative; overflow: hidden;"
                             title="${section.description}"
                             data-section-index="${index}">
                            <div style="text-align: center; position: relative; z-index: 2;">
                                <div style="font-weight: 600; font-size: 0.9rem;">${
                                  section.name
                                }</div>
                                <div style="font-size: 0.7rem; opacity: 0.8; margin-top: 0.25rem;">${
                                  section.description
                                }</div>
                            </div>
                            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(255,255,255,0.05) 0%, transparent 50%); pointer-events: none;"></div>
                        </div>
                    `
                      )
                      .join("")}
                </div>

                ${generateAdditionalPagesHTML(wireframes.additionalPages)}
            </div>
        `;
  }

  function generateAdditionalPagesHTML(additionalPages) {
    if (!additionalPages || !additionalPages.length) return "";

    return `
            <div style="margin-top: 2rem;">
                <h4 style="font-weight: 600; margin-bottom: 1rem;">Additional Pages Structure:</h4>
                <div class="aiwcg-grid aiwcg-grid-2" style="gap: 1rem;">
                    ${additionalPages
                      .map(
                        (page) => `
                        <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1rem; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <h5 style="font-weight: 600; margin-bottom: 0.5rem; color: #8b5cf6;">${
                              page.name
                            }</h5>
                            <p style="font-size: 0.875rem; color: #d1d5db; margin-bottom: 0.75rem; line-height: 1.4;">${
                              page.purpose
                            }</p>
                            <div style="font-size: 0.75rem;">
                                <strong style="color: #a855f7;">Key Elements:</strong>
                                <ul style="margin: 0.25rem 0 0 1rem; color: #9ca3af; line-height: 1.4;">
                                    ${page.keyElements
                                      .map((element) => `<li>${element}</li>`)
                                      .join("")}
                                </ul>
                            </div>
                        </div>
                    `
                      )
                      .join("")}
                </div>
            </div>
        `;
  }

  function generateColorSchemeHTML(colorScheme) {
    if (!colorScheme) return "";

    return `
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                    </svg>
                    Color Palette & Design Rationale
                </h3>
                
                <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                    ${Object.entries(colorScheme)
                      .filter(([key]) => key !== "rationale")
                      .map(
                        ([name, color]) => `
                        <div style="text-align: center; cursor: pointer;" onclick="copyToClipboard('${color}', this)" title="Click to copy ${color}">
                            <div class="aiwcg-color-swatch" style="background-color: ${color}; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></div>
                            <div style="font-size: 0.75rem; text-transform: capitalize; margin-bottom: 0.25rem; font-weight: 500;">${name}</div>
                            <div style="font-size: 0.75rem; font-family: monospace; color: #9ca3af; background: rgba(0,0,0,0.3); padding: 0.25rem; border-radius: 0.25rem;">${color}</div>
                        </div>
                    `
                      )
                      .join("")}
                </div>
                
                ${
                  colorScheme.rationale
                    ? `
                <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1rem; border-left: 3px solid #8b5cf6;">
                    <strong style="color: #a855f7;">Design Rationale:</strong> 
                    <span style="color: #d1d5db;">${colorScheme.rationale}</span>
                </div>
                `
                    : ""
                }
            </div>
        `;
  }

  function generateFeaturesHTML(features) {
    if (!features) return "";

    return `
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recommended Features & Integrations
                </h3>
                
                <div style="display: grid; gap: 1rem;">
                    ${
                      features.essential
                        ? generateFeatureSection(
                            "Essential Features",
                            features.essential,
                            "#22c55e",
                            "These features are critical for your website's success"
                          )
                        : ""
                    }
                    ${
                      features.recommended
                        ? generateFeatureSection(
                            "Recommended Features",
                            features.recommended,
                            "#3b82f6",
                            "These features will enhance user experience and business value"
                          )
                        : ""
                    }
                    ${
                      features.advanced
                        ? generateFeatureSection(
                            "Advanced Features",
                            features.advanced,
                            "#8b5cf6",
                            "These features provide competitive advantages and future growth"
                          )
                        : ""
                    }
                    ${
                      features.integrations
                        ? generateFeatureSection(
                            "Third-party Integrations",
                            features.integrations,
                            "#f59e0b",
                            "External services that will enhance functionality"
                          )
                        : ""
                    }
                </div>
            </div>
        `;
  }

  function generateFeatureSection(title, featureList, color, description) {
    return `
            <div class="aiwcg-feature-badge" style="background: ${color}15; border-color: ${color}40;">
                <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                    <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem; color: ${color};" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span style="font-weight: 600; color: ${color};">${title}</span>
                </div>
                <p style="font-size: 0.8rem; color: #9ca3af; margin-bottom: 0.75rem; font-style: italic;">${description}</p>
                <div style="font-size: 0.875rem; line-height: 1.5;">
                    ${featureList
                      .map(
                        (feature) => `
                        <div style="display: flex; align-items: start; margin-bottom: 0.5rem;">
                            <span style="color: ${color}; margin-right: 0.5rem; font-weight: bold;">•</span>
                            <span>${feature}</span>
                        </div>
                    `
                      )
                      .join("")}
                </div>
            </div>
        `;
  }

  function generatePerformanceHTML(performance) {
    if (!performance) return "";

    const metrics = [
      { key: "seoScore", label: "SEO Optimization", color: "#22c55e" },
      { key: "performanceScore", label: "Page Speed", color: "#3b82f6" },
      { key: "accessibilityScore", label: "Accessibility", color: "#8b5cf6" },
      { key: "mobileScore", label: "Mobile Experience", color: "#f59e0b" },
    ];

    return `
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Expected Performance Metrics
                </h3>
                
                <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                    ${metrics
                      .filter((metric) => performance[metric.key])
                      .map((metric) => {
                        const score = performance[metric.key];
                        return `
                            <div style="background: rgba(31, 41, 55, 0.3); padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(255, 255, 255, 0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <span style="font-size: 0.875rem; font-weight: 500;">${
                                      metric.label
                                    }</span>
                                    <span style="font-weight: 600; color: ${
                                      metric.color
                                    };">${score}/100</span>
                                </div>
                                <div style="width: 100%; background: #374151; border-radius: 9999px; height: 0.5rem; overflow: hidden;">
                                    <div style="background: ${
                                      metric.color
                                    }; height: 100%; border-radius: 9999px; width: ${score}%; transition: width 1s ease-in-out;"></div>
                                </div>
                                <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #9ca3af;">
                                    ${getPerformanceDescription(
                                      metric.key,
                                      score
                                    )}
                                </div>
                            </div>
                        `;
                      })
                      .join("")}
                </div>
            </div>
        `;
  }

  function getPerformanceDescription(metric, score) {
    const descriptions = {
      seoScore:
        score >= 90
          ? "Excellent search engine optimization"
          : "Good SEO with room for improvement",
      performanceScore:
        score >= 90
          ? "Fast loading times expected"
          : "Good performance with optimization",
      accessibilityScore:
        score >= 95
          ? "Fully accessible to all users"
          : "Good accessibility compliance",
      mobileScore:
        score >= 90
          ? "Excellent mobile experience"
          : "Good mobile responsiveness",
    };
    return descriptions[metric] || "Performance metric";
  }

  function generateContentStrategyHTML(concept) {
    if (!concept.contentStrategy && !concept.seoStrategy) return "";

    return `
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Content & SEO Strategy
                </h3>
                
                <div class="aiwcg-grid aiwcg-grid-2" style="gap: 1.5rem;">
                    ${
                      concept.contentStrategy
                        ? `
                    <div style="background: rgba(59, 130, 246, 0.1); border-radius: 0.5rem; padding: 1rem; border: 1px solid rgba(59, 130, 246, 0.3);">
                        <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: #3b82f6; display: flex; align-items: center;">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Content Strategy
                        </h4>
                        <p style="color: #d1d5db; line-height: 1.6; font-size: 0.9rem;">${concept.contentStrategy}</p>
                    </div>
                    `
                        : ""
                    }
                    
                    ${
                      concept.seoStrategy
                        ? `
                    <div style="background: rgba(34, 197, 94, 0.1); border-radius: 0.5rem; padding: 1rem; border: 1px solid rgba(34, 197, 94, 0.3);">
                        <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: #22c55e; display: flex; align-items: center;">
                            <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            SEO Strategy
                        </h4>
                        <p style="color: #d1d5db; line-height: 1.6; font-size: 0.9rem;">${concept.seoStrategy}</p>
                    </div>
                    `
                        : ""
                    }
                </div>
            </div>
        `;
  }

  function generateActionButtonsHTML() {
    return `
            <div class="aiwcg-grid aiwcg-grid-3" style="gap: 1rem; margin-top: 2rem;">
                <button onclick="aiwcgDownloadConcept()" class="aiwcg-button" style="background: linear-gradient(to right, #22c55e, #16a34a);">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Concept
                </button>
                
                <button onclick="aiwcgGenerateDemo()" class="aiwcg-button" style="background: linear-gradient(to right, #f97316, #ea580c);">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Build Live Demo
                </button>
                
                <button onclick="aiwcgRequestQuote()" class="aiwcg-button">
                    <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Request Quote
                </button>
            </div>
        `;
  }

  function displayError(message) {
    $("#aiwcg-results-section").html(`
            <div class="aiwcg-glass" style="text-align: center; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                <div style="width: 4rem; height: 4rem; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #ef4444;">Generation Failed</h3>
                <p style="color: #d1d5db; margin-bottom: 2rem;">${message}</p>
                <button onclick="aiwcgResetGenerator()" class="aiwcg-button">Try Again</button>
            </div>
        `);
  }

  // Utility functions
  function copyToClipboard(text, element) {
    navigator.clipboard
      .writeText(text)
      .then(function () {
        // Show feedback
        const originalText = $(element).find("div:last").text();
        $(element).find("div:last").text("Copied!").css("color", "#22c55e");
        setTimeout(() => {
          $(element)
            .find("div:last")
            .text(originalText)
            .css("color", "#9ca3af");
        }, 1500);
      })
      .catch(function () {
        // Fallback for older browsers
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("copy");
        document.body.removeChild(textArea);
      });
  }

  // Global functions for WordPress
  window.aiwcgResetGenerator = function () {
    // Reset form data
    Object.keys(formData).forEach((key) => {
      if (key === "features") {
        formData[key] = [];
      } else {
        formData[key] = "";
      }
    });

    // Reset form inputs
    $('[id^="aiwcg-"]').filter("input, select, textarea").val("");

    // Reset selections
    $(".aiwcg-option-button").removeClass("selected");

    // Reset progress steps
    $(".aiwcg-progress-step")
      .removeClass("active")
      .each(function () {
        $(this)
          .find("div:first div:first")
          .html(
            '<div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>'
          );
      });

    // Show form, hide others
    $("#aiwcg-form-section").removeClass("aiwcg-hidden");
    $("#aiwcg-loading-section").addClass("aiwcg-hidden");
    $("#aiwcg-results-section").addClass("aiwcg-hidden");

    // Scroll to top
    $("html, body").animate({ scrollTop: 0 }, 800);

    validateForm();
  };

  window.aiwcgDownloadConcept = function () {
    // This would integrate with a PDF generation service
    alert(
      "Download feature coming soon! The concept will be available as a comprehensive PDF report including all wireframes, specifications, and recommendations."
    );
  };

  window.aiwcgGenerateDemo = function () {
    // This would trigger demo website generation
    alert(
      "Live demo generation feature coming soon! This will create a working prototype of your website based on the AI concept."
    );
  };

  window.aiwcgRequestQuote = function () {
    // This would integrate with a contact/CRM system
    const concept = $("#aiwcg-results-section h2").first().text();
    const message = `I'm interested in getting a quote for the "${concept}" website concept generated by your AI tool.`;

    // You can customize this to integrate with your contact system
    const contactUrl = `mailto:info@yourcompany.com?subject=Quote Request for AI Generated Concept&body=${encodeURIComponent(
      message
    )}`;
    window.open(contactUrl);
  };

  // Enhanced wireframe interactions
  $(document)
    .on("mouseenter", ".aiwcg-wireframe-section", function () {
      $(this).css({
        transform: "scale(1.02)",
        "box-shadow": "0 8px 25px rgba(0,0,0,0.3)",
        "z-index": "10",
      });
    })
    .on("mouseleave", ".aiwcg-wireframe-section", function () {
      $(this).css({
        transform: "scale(1)",
        "box-shadow": "none",
        "z-index": "1",
      });
    });

  // Enhanced color swatch interactions
  $(document).on("click", '[onclick*="copyToClipboard"]', function () {
    $(this).find(".aiwcg-color-swatch").css("transform", "scale(1.2)");
    setTimeout(() => {
      $(this).find(".aiwcg-color-swatch").css("transform", "scale(1)");
    }, 200);
  });
})(jQuery);
