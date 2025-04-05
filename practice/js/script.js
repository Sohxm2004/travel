document.addEventListener('DOMContentLoaded', function() {
  // Mobile menu toggle
  let menu = document.querySelector('#menu-btn');
  let navbar = document.querySelector('.header .navbar');

  if (menu && navbar) {
      menu.onclick = () => {
          menu.classList.toggle('fa-times');
          navbar.classList.toggle('active');
      };
  }

  // Remove menu on scroll
  window.onscroll = () => {
      if (menu) menu.classList.remove('fa-times');
      if (navbar) navbar.classList.remove('active');
  };

  // Home slider
  if (document.querySelector('.home-slider')) {
      var homeSwiper = new Swiper(".home-slider", {
          loop: true,
          navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
          },
      });
  }

  // Reviews slider
  if (document.querySelector('.reviews-slider')) {
      var reviewsSwiper = new Swiper(".reviews-slider", {
          grabCursor: true,
          loop: true,
          autoHeight: true,
          spaceBetween: 20,
          breakpoints: {
              0: {
                  slidesPerView: 1,
              },
              700: {
                  slidesPerView: 2,
              },
              1000: {
                  slidesPerView: 3,
              },
          },
      });
  }

  // Load more button functionality
  let loadMoreBtn = document.querySelector('.packages .load-more .btn');
  let currentItem = 3;

  if (loadMoreBtn) {
      loadMoreBtn.onclick = () => {
          let boxes = [...document.querySelectorAll('.packages .box-container .box')];
          for (let i = currentItem; i < currentItem + 3; i++) {
              if (boxes[i]) {
                  boxes[i].style.display = 'inline-block';
              }
          }
          currentItem += 3;
          if (currentItem >= boxes.length) {
              loadMoreBtn.style.display = 'none';
          }
      }
  }

  // Form toggle function
  window.showForm = function(formId) {
      document.querySelectorAll(".form-box").forEach(form => {
          form.classList.remove("active");
      });
      let targetForm = document.getElementById(formId);
      if (targetForm) {
          targetForm.classList.add("active");
      }
  };
});

// chatbot starts here 


document.addEventListener("DOMContentLoaded", function() {
  // DOM Elements
  const chatbotContainer = document.getElementById("chatbot-container");
  const closeBtn = document.getElementById("close-btn");
  const sendBtn = document.getElementById("send-btn");
  const chatInput = document.getElementById("chatbot-input");
  const chatMessages = document.getElementById("chatbot-messages");
  const chatIcon = document.getElementById("chatbot-icon");

  // Chatbot state
  let chatbotInitialized = false;
  let isWaitingForResponse = false;

  // Initialize chatbot on first open
  chatIcon.addEventListener("click", function() {
    chatbotContainer.classList.remove("hidden");
    chatIcon.style.display = "none";
    chatInput.focus();
    
    if (!chatbotInitialized) {
      appendMessage("bot", "Hello! I'm your travel assistant. How can I help you today?");
      chatbotInitialized = true;
    }
  });

  // Close chatbot
  closeBtn.addEventListener("click", function() {
    chatbotContainer.classList.add("hidden");
    chatIcon.style.display = "flex";
  });

  // Message sending
  sendBtn.addEventListener("click", handleSendMessage);
  chatInput.addEventListener("keypress", function(e) {
    if (e.key === "Enter") handleSendMessage();
  });

  async function handleSendMessage() {
    if (isWaitingForResponse) return;
    
    const message = chatInput.value.trim();
    if (!message) return;
    
    // Display user message
    appendMessage("user", message);
    chatInput.value = "";
    
    // Show typing indicator
    showTypingIndicator();
    isWaitingForResponse = true;
    
    try {
      const response = await getBotResponse(message);
      appendMessage("bot", response);
    } catch (error) {
      console.error("Chatbot Error:", error);
      appendMessage("bot", "Sorry, I'm having trouble responding. Please try again later.");
    } finally {
      removeTypingIndicator();
      isWaitingForResponse = false;
    }
  }

  function appendMessage(sender, text) {
    const messageDiv = document.createElement("div");
    messageDiv.className = `message ${sender}`;
    messageDiv.textContent = text;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function showTypingIndicator() {
    const typingIndicator = document.createElement("div");
    typingIndicator.id = "typing-indicator";
    typingIndicator.className = "message bot typing";
    typingIndicator.innerHTML = `
      <div class="typing-dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    `;
    chatMessages.appendChild(typingIndicator);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function removeTypingIndicator() {
    const indicator = document.getElementById("typing-indicator");
    if (indicator) indicator.remove();
  }

  async function getBotResponse(userMessage) {
    const API_KEY = "AIzaSyBAcAqPJ0c3tOczXCfi96idkqiz3ubNayk";
    const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;
    
    const requestBody = {
      contents: [{
        parts: [{ 
          text: `You are a helpful travel assistant. Provide concise, helpful answers to travel-related questions. 
          Be friendly and professional. If asked about non-travel topics, politely decline. 
          Current question: ${userMessage}` 
        }]
      }],
      safetySettings: [{
        category: "HARM_CATEGORY_DANGEROUS_CONTENT",
        threshold: "BLOCK_ONLY_HIGH"
      }],
      generationConfig: {
        temperature: 0.7,
        maxOutputTokens: 1000
      }
    };

    const response = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(requestBody)
    });

    if (!response.ok) {
      throw new Error(`API request failed with status ${response.status}`);
    }

    const data = await response.json();
    
    if (!data.candidates?.[0]?.content?.parts?.[0]?.text) {
      throw new Error("Invalid response format from API");
    }

    return data.candidates[0].content.parts[0].text;
  }
});

window.onpageshow = function(event) {
  if (event.persisted) {
      window.location.reload();
  }
};