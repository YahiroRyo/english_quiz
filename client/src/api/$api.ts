import type { AspidaClient } from 'aspida'
import type { Methods as Methods0 } from './api/login'
import type { Methods as Methods1 } from './api/logout'
import type { Methods as Methods2 } from './api/quiz/categoryList'
import type { Methods as Methods3 } from './api/register'
import type { Methods as Methods4 } from './sanctum/csrf-cookie'

const api = <T>({ baseURL, fetch }: AspidaClient<T>) => {
  const prefix = (baseURL === undefined ? '' : baseURL).replace(/\/$/, '')
  const PATH0 = '/api/login'
  const PATH1 = '/api/logout'
  const PATH2 = '/api/quiz/categoryList'
  const PATH3 = '/api/register'
  const PATH4 = '/sanctum/csrf-cookie'
  const GET = 'GET'
  const POST = 'POST'

  return {
    api: {
      login: {
        post: (option: { body: Methods0['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods0['post']['resBody']>(prefix, PATH0, POST, option).json(),
        $post: (option: { body: Methods0['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods0['post']['resBody']>(prefix, PATH0, POST, option).json().then(r => r.body),
        $path: () => `${prefix}${PATH0}`
      },
      logout: {
        post: (option: { headers: Methods1['post']['reqHeaders'], config?: T | undefined }) =>
          fetch<Methods1['post']['resBody']>(prefix, PATH1, POST, option).json(),
        $post: (option: { headers: Methods1['post']['reqHeaders'], config?: T | undefined }) =>
          fetch<Methods1['post']['resBody']>(prefix, PATH1, POST, option).json().then(r => r.body),
        $path: () => `${prefix}${PATH1}`
      },
      quiz: {
        categoryList: {
          get: (option: { headers: Methods2['get']['reqHeaders'], config?: T | undefined }) =>
            fetch<Methods2['get']['resBody']>(prefix, PATH2, GET, option).json(),
          $get: (option: { headers: Methods2['get']['reqHeaders'], config?: T | undefined }) =>
            fetch<Methods2['get']['resBody']>(prefix, PATH2, GET, option).json().then(r => r.body),
          $path: () => `${prefix}${PATH2}`
        }
      },
      register: {
        post: (option: { body: Methods3['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods3['post']['resBody']>(prefix, PATH3, POST, option, 'FormData').json(),
        $post: (option: { body: Methods3['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods3['post']['resBody']>(prefix, PATH3, POST, option, 'FormData').json().then(r => r.body),
        $path: () => `${prefix}${PATH3}`
      }
    },
    sanctum: {
      csrf_cookie: {
        get: (option?: { config?: T | undefined } | undefined) =>
          fetch<Methods4['get']['resBody']>(prefix, PATH4, GET, option).json(),
        $get: (option?: { config?: T | undefined } | undefined) =>
          fetch<Methods4['get']['resBody']>(prefix, PATH4, GET, option).json().then(r => r.body),
        $path: () => `${prefix}${PATH4}`
      }
    }
  }
}

export type ApiInstance = ReturnType<typeof api>
export default api
