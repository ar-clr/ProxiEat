/**
 * Sends a user message to the ProxiE AI backend.
 *
 * Returns:
 * {
 *   text: string,
 *   model: string|null,
 *   suggestions: array
 * }
 */

async function generateAIResponse(message) {

    const response = await fetch("chatbot-api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ message })
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    const data = await response.json();
    console.log(data);

    // Ensure expected properties always exist
    return {
        text: data.text ?? "No response received.",
        model: data.model ?? null,
        suggestions: data.suggestions ?? []
    };

}