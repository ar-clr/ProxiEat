async function generateAIResponse(message) {
    try {
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

        return await response.json();

    } catch (error) {
        console.error("AI Request Failed:", error);

        return {
            text: "Sorry, I'm having trouble connecting right now. Please try again later.",
            suggestions: []
        };
    }
}