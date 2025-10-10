import { db } from './firebase-config.js';
import { collection, addDoc } from "https://www.gstatic.com/firebasejs/9.22.1/firebase-firestore.js";

// Helper: Submit job application to Firestore via SDK
export async function submitJobApplication(applicationData) {
    const userId = 'user1234'; // Temporary user ID

    try {
        // Save to Firestore collection "applications"
        const docRef = await addDoc(collection(db, "applications"), {
            ...applicationData,
            user_id: userId,
            submitted_at: new Date().toISOString()
        });
        return docRef.id;
    } catch (err) {
        console.error('Firestore error:', err);
        throw err;
    }
}

