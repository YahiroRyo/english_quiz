import million from "million/compiler";

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: true,
  trailingSlash: true,
  images: { domains: ["yappi-english-quiz.s3.ap-northeast-1.amazonaws.com"] },
};

export default million.next(nextConfig);
