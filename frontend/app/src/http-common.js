import axios from "axios";

export default axios.create({
    baseURL: "http://localhost:8787/api",
    headers: {
        "Content-type": "application/json"
    }
});