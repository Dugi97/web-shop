import { FETCH_PROJECTS } from '../actions';

export default function (state = {}, action) {
    switch (action.type) {
        case FETCH_PROJECTS:
            return [{id:1},{id:2},{id:3}];
        default:
            return state;
    }
}