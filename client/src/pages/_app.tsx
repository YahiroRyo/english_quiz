import type { AppProps } from "next/app";
import { Noto_Sans_JP } from "@next/font/google";
import "../styles/global.scss";

const notojp = Noto_Sans_JP({
  weight: ["100", "200", "300", "400", "500", "600", "700", "800", "900"],
  subsets: ["latin"],
  display: "swap",
});

export default function App({ Component, pageProps }: AppProps) {
  return <Component className={notojp.className} {...pageProps} />;
}
