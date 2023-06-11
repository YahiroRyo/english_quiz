import { useEffect, useState } from "react";

export const useScroll = () => {
  const [position, setPosition] = useState({ x: 0, y: 0 });

  useEffect(() => {
    const handleScroll = () => {
      setPosition({
        x: window.scrollX,
        y: window.scrollY,
      });
    };

    window.addEventListener("scroll", handleScroll);

    return window.removeEventListener("scroll", handleScroll);
  });

  useEffect(() => {
    window.scroll(position.x, position.y);
  }, [position]);

  const toMostUnderPage = () => {
    setPosition({
      x: position.x,
      y:
        document.documentElement.scrollHeight -
        document.documentElement.clientHeight,
    });
  };

  return { position, setPosition, toMostUnderPage };
};
