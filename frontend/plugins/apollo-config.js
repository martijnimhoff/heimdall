import Cookies from 'js-cookie'
import {createHttpLink} from 'apollo-link-http'
import {setContext} from 'apollo-link-context'

export default (context) => {
  // Configure the http link
  // todo: set uri through env var.
  const httpLink = createHttpLink({
    uri: 'http://heimdall.local/graphql',
    credentials: 'include',
    headers: {
      accept: 'application/json, text/plain, */*',
    }
  })

  // Use setContext to fetch the xsrf token at runtime, this makes sure we put the most recent xsrf token into the headers
  // If we add this part to the config above, then the xsrf token will only be set when the app is initially loaded. That does not work.
  const authLink = setContext((_, {headers}) => {
    return {
      headers: {
        ...headers,
        'X-XSRF-TOKEN': Cookies.get('XSRF-TOKEN')
      },
    }
  })

  return {
    // Disable the default http link so we can manually insert our own httplink
    defaultHttpLink: false,
    // Manually insert our own httplink
    link: authLink.concat(httpLink),
    // overwrite the default getAuth function, since that one is only needed when using a token based authentication. We use cookie based.
    getAuth: () => {
      return undefined
    },
  }
}
