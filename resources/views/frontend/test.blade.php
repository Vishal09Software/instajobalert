<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Default SEO Meta Tags -->
    <title id="seo-title">AI Question Answer - Get Instant Answers</title>
    <meta name="description" id="seo-description" content="Ask any question and get AI-powered answers instantly">
    <meta name="keywords" id="seo-keywords" content="AI, question answer, artificial intelligence, chatbot">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" id="og-title" content="AI Question Answer">
    <meta property="og:description" id="og-description" content="Get AI-powered answers to your questions">
    <meta property="og:type" id="og-type" content="website">
    <meta property="og:url" id="og-url" content="{{ url()->current() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="text"]:focus {
            outline: none;
            border-color: #4CAF50;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        #result {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
            white-space: pre-wrap;
            word-wrap: break-word;
            min-height: 50px;
        }
        .loading {
            color: #666;
            font-style: italic;
        }
        .error {
            color: #d32f2f;
            border-left-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>AI Question Answer Generator</h1>

        <div class="input-group">
            <label for="query">Enter your question:</label>
            <input type="text" id="query" placeholder="Enter your query" value="">
        </div>

        <button id="countBtn">Generate Answer</button>

        <div id="result" style="display: none;"></div>
    </div>

    <script>
        const countBtn = document.getElementById('countBtn');
        const queryInput = document.getElementById('query');
        const resultEl = document.getElementById('result');

        // Function to update SEO and Open Graph meta tags
        function updateMetaTags(seoData, ogData) {
            if (seoData) {
                if (seoData.title) {
                    document.getElementById('seo-title').textContent = seoData.title;
                    document.title = seoData.title;
                }
                if (seoData.description) {
                    document.getElementById('seo-description').setAttribute('content', seoData.description);
                }
                if (seoData.keywords) {
                    document.getElementById('seo-keywords').setAttribute('content', seoData.keywords);
                }
            }

            if (ogData) {
                if (ogData.title) {
                    document.getElementById('og-title').setAttribute('content', ogData.title);
                }
                if (ogData.description) {
                    document.getElementById('og-description').setAttribute('content', ogData.description);
                }
                if (ogData.type) {
                    document.getElementById('og-type').setAttribute('content', ogData.type);
                }
                if (ogData.url) {
                    document.getElementById('og-url').setAttribute('content', ogData.url);
                }
            }
        }

        countBtn.addEventListener('click', async function() {
            const query = queryInput.value.trim();

            if (!query) {
                resultEl.textContent = 'Please enter a question';
                resultEl.className = 'error';
                resultEl.style.display = 'block';
                return;
            }

            // Disable button and show loading
            countBtn.disabled = true;
            resultEl.style.display = 'block';
            resultEl.className = 'loading';
            resultEl.textContent = 'Loading...';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('/seo-generator-api', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ query: query })
                });

                const data = await response.json();

                if (data.error) {
                    resultEl.textContent = 'Error: ' + data.error;
                    resultEl.className = 'error';
                } else {
                    // Display answer
                    let answer = data.answer || '';
                    if (!answer && data.choices && data.choices[0] && data.choices[0].message && data.choices[0].message.content) {
                        answer = data.choices[0].message.content;
                    }

                    resultEl.textContent = answer || 'No answer received';
                    resultEl.className = '';

                    // Update SEO and Open Graph meta tags
                    if (data.seo && data.og) {
                        updateMetaTags(data.seo, data.og);
                    }
                }
            } catch (err) {
                resultEl.textContent = 'Error: ' + err.message;
                resultEl.className = 'error';
            } finally {
                countBtn.disabled = false;
            }
        });

        // Allow Enter key to trigger generate
        queryInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                countBtn.click();
            }
        });
    </script>
</body>
</html>
