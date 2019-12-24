import { combineReducers } from 'redux';

import Reducer from './reducer';

const rootReducer = combineReducers({
    projects: Reducer,
});

export default rootReducer;
