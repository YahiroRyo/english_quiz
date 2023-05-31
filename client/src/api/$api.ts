import type { AspidaClient } from 'aspida'
import type { Methods as Methods0 } from './api/login'
import type { Methods as Methods1 } from './api/logout'
import type { Methods as Methods2 } from './api/quiz'
import type { Methods as Methods3 } from './api/quiz/categoryList'
import type { Methods as Methods4 } from './api/quiz/categoryList/_quizCategoryId@number'
import type { Methods as Methods5 } from './api/register'
import type { Methods as Methods6 } from './sanctum/csrf-cookie'

const api = <T>({ baseURL, fetch }: AspidaClient<T>) => {
  const prefix = (baseURL === undefined ? '' : baseURL).replace(/\/$/, '')
  const PATH0 = '/api/login'
  const PATH1 = '/api/logout'
  const PATH2 = '/api/quiz'
  const PATH3 = '/api/quiz/categoryList'
  const PATH4 = '/api/register'
  const PATH5 = '/sanctum/csrf-cookie'
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
          _quizCategoryId: (val3: number) => {
            const prefix3 = `${PATH3}/${val3}`

            return {
              get: (option: { headers: Methods4['get']['reqHeaders'], config?: T | undefined }) =>
                fetch<Methods4['get']['resBody']>(prefix, prefix3, GET, option).json(),
              $get: (option: { headers: Methods4['get']['reqHeaders'], config?: T | undefined }) =>
                fetch<Methods4['get']['resBody']>(prefix, prefix3, GET, option).json().then(r => r.body),
              $path: () => `${prefix}${prefix3}`
            }
          },
          get: (option: { headers: Methods3['get']['reqHeaders'], config?: T | undefined }) =>
            fetch<Methods3['get']['resBody']>(prefix, PATH3, GET, option).json(),
          $get: (option: { headers: Methods3['get']['reqHeaders'], config?: T | undefined }) =>
            fetch<Methods3['get']['resBody']>(prefix, PATH3, GET, option).json().then(r => r.body),
          $path: () => `${prefix}${PATH3}`
        },
        post: (option: { body: Methods2['post']['reqBody'], headers: Methods2['post']['reqHeaders'], config?: T | undefined }) =>
          fetch<Methods2['post']['resBody']>(prefix, PATH2, POST, option).json(),
        $post: (option: { body: Methods2['post']['reqBody'], headers: Methods2['post']['reqHeaders'], config?: T | undefined }) =>
          fetch<Methods2['post']['resBody']>(prefix, PATH2, POST, option).json().then(r => r.body),
        $path: () => `${prefix}${PATH2}`
      },
      register: {
        post: (option: { body: Methods5['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods5['post']['resBody']>(prefix, PATH4, POST, option, 'FormData').json(),
        $post: (option: { body: Methods5['post']['reqBody'], config?: T | undefined }) =>
          fetch<Methods5['post']['resBody']>(prefix, PATH4, POST, option, 'FormData').json().then(r => r.body),
        $path: () => `${prefix}${PATH4}`
      }
    },
    sanctum: {
      csrf_cookie: {
        get: (option?: { config?: T | undefined } | undefined) =>
          fetch<Methods6['get']['resBody']>(prefix, PATH5, GET, option).json(),
        $get: (option?: { config?: T | undefined } | undefined) =>
          fetch<Methods6['get']['resBody']>(prefix, PATH5, GET, option).json().then(r => r.body),
        $path: () => `${prefix}${PATH5}`
      }
    }
  }
}

export type ApiInstance = ReturnType<typeof api>
export default api
