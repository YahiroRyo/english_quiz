import { AlertError } from "@/components/atoms/Alert/AlertError";

export const AlertDesignType = {
  error: "error",
} as const;

type AlertDesignType = keyof typeof AlertDesignType;

type Props = {
  designType: AlertDesignType;

  children?: React.ReactNode;
};

export const Alert = ({ children, designType }: Props) => {
  if (!children) {
    return <></>;
  }
  if (designType === "error") {
    return <AlertError>{children}</AlertError>;
  }

  throw Error("The specified designType is undefined.");
};
