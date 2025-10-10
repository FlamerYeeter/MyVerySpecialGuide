// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getFirestore } from "firebase/firestore";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCb2wiXLmVeOJS6T25tXk8sgbgp4zJvqRM",
  authDomain: "myveryspecialguide.firebaseapp.com",
  projectId: "myveryspecialguide",
  storageBucket: "myveryspecialguide.firebasestorage.app",
  messagingSenderId: "1092348597749",
  appId: "1:1092348597749:web:2e662681864dd53c9cbcbc"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize Firestore DB and export both
const db = getFirestore(app);

// Export named so other modules can import { app, db }
export { app, db };