import axios from 'axios';

export const FETCH_PROJECTS = "FETCH_PROJECTS";

export function fetchProjects() {
    const request = axios.get("http://www.json-generator.com/api/json/get/cqdFrEpUUi?indent=2");
    // const request = axios.get("/api/content/project");

    return {
        type: FETCH_PROJECTS,
        payload: request
    }
}
