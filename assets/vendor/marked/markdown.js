/**
 * Lightweight Markdown Renderer
 * Supports:
 * - # Heading
 * - ## Heading
 * - ### Heading
 * - **bold**
 * - *italic*
 * - `inline code`
 * - ```code blocks```
 * - unordered lists
 * - ordered lists
 * - links
 */

function escapeHTML(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

function renderMarkdown(markdown) {

    if (!markdown) return "";

    let html = escapeHTML(markdown);

    // Code blocks
    html = html.replace(/```([\s\S]*?)```/g, (_, code) => {
        return `<pre><code>${code.trim()}</code></pre>`;
    });

    // Inline code
    html = html.replace(/`([^`]+)`/g, "<code>$1</code>");

    // Headings
    html = html.replace(/^### (.*)$/gm, "<h3>$1</h3>");
    html = html.replace(/^## (.*)$/gm, "<h2>$1</h2>");
    html = html.replace(/^# (.*)$/gm, "<h1>$1</h1>");

    // Bold
    html = html.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

    // Italic
    html = html.replace(/\*(.*?)\*/g, "<em>$1</em>");

    // Links
    html = html.replace(
        /\[([^\]]+)\]\((.*?)\)/g,
        '<a href="$2" target="_blank" rel="noopener">$1</a>'
    );

    // Ordered Lists
    html = html.replace(
        /(?:^\d+\..+(?:\n|$))+?/gm,
        match => {
            const items = match
                .trim()
                .split("\n")
                .map(line => line.replace(/^\d+\.\s*/, ""))
                .map(item => `<li>${item}</li>`)
                .join("");

            return `<ol>${items}</ol>`;
        }
    );

    // Bullet Lists
    html = html.replace(
        /(?:^[-*]\s.+(?:\n|$))+?/gm,
        match => {
            const items = match
                .trim()
                .split("\n")
                .map(line => line.replace(/^[-*]\s*/, ""))
                .map(item => `<li>${item}</li>`)
                .join("");

            return `<ul>${items}</ul>`;
        }
    );

    // Paragraphs
    html = html
        .split(/\n{2,}/)
        .map(block => {

            if (/^<(h1|h2|h3|ul|ol|pre)/.test(block.trim()))
                return block;

            return `<p>${block.replace(/\n/g, "<br>")}</p>`;

        })
        .join("");

    return html;
}