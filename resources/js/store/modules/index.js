import { createLogger } from 'vuex';
import app from './app';
import area from './area';
import lang from './lang';

export const modules = {
	app,
	area,
	lang,
}

export const debug = globalThis.process?.env?.NODE_ENV !== 'production';

export const plugin = !debug ? [createLogger()] : []
