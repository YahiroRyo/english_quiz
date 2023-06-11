import styles from "./index.module.scss";
import { LergeDarkBoldText } from "@/components/atoms/Text/LergeDarkBoldText";
import { useAuth } from "@/hooks/user/useAuth";
import { useRouter } from "next/router";
import { apiAddMessage, apiQuiz } from "@/modules/api/quiz";
import { ROUTE_PATHNAME } from "@/constants/route";
import { Alert } from "@/components/molecures/Alert";
import { useSafePush } from "@/hooks/route/useSafePush";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { QuestionIcon } from "@/components/atoms/Icon/QuestionIcon";
import { MediumDarkBoldText } from "@/components/atoms/Text/MediumDarkBoldText";
import { AnswerIcon } from "@/components/atoms/Icon/AnswerIcon";
import { InputMediumGrayTextArea } from "@/components/atoms/Input/InputMediumGrayTextArea";
import { SubmitHandler, useForm } from "react-hook-form";
import { GreenButton } from "@/components/atoms/Button/GreenButton";
import { faPaperPlane } from "@fortawesome/free-solid-svg-icons";
import { ChatMessage } from "@/components/molecures/ChatMessage";
import { ValidationError } from "@/components/molecures/ValidationError";
import { PostRequest } from "@/api/api/quiz/_quizId@number/add";
import axios from "axios";
import { ErrorResponse, errorDictToString } from "@/types/response";
import { useState } from "react";
import { ERROR_MESSAGE } from "@/constants/api";

export const QuizSolutionAnalysis = () => {
  const router = useRouter();
  const safePush = useSafePush();
  const [user, setUser, isReady] = useAuth();
  const { quizId } = router.query;
  const [error, setError] = useState<string>();
  const [isSending, setIsSending] = useState(false);

  const {
    data,
    error: quizResponseError,
    isLoading,
    status,
    mutate,
    retryCount,
    initRetryCount,
  } = apiQuiz(Number(quizId), user?.token!);

  const answerForm = useForm<PostRequest>();
  const chatForm = useForm<PostRequest>();

  const handleAnswer: SubmitHandler<PostRequest> = async (request) => {
    try {
      setIsSending(true);
      const response = await apiAddMessage(
        Number(quizId),
        request.message,
        user?.token!
      );
      await mutate(response);
      setIsSending(false);
      chatForm.reset();
    } catch (e) {
      if (axios.isAxiosError(e)) {
        const response = e.response!.data as ErrorResponse;
        const status = e.response!.status;

        if (status === 400) {
          setError(errorDictToString(response.data));
          return;
        }

        setError(response.message);
        return;
      }

      setError(ERROR_MESSAGE.UNKNOWN_ERROR);
      return;
    }
  };

  if (!isReady) {
    return <></>;
  }

  if (isLoading) {
    return <></>;
  }

  if (status === 401 || status == 403) {
    if (retryCount >= 5) {
      initRetryCount();
      setUser(undefined);
      safePush(ROUTE_PATHNAME.LOGIN);
      return <></>;
    }

    setTimeout(mutate, 500);
    return <></>;
  }

  initRetryCount();

  if (quizResponseError) {
    return <Alert designType="error">{quizResponseError}</Alert>;
  }

  if (!data) {
    return <></>;
  }

  const needsAnswer = () => {
    return data.data.response == undefined;
  };

  const dontNeedsAnswer = () => {
    return !needsAnswer();
  };

  return (
    <div className={styles.quizSolutionAnalysis}>
      <Alert designType="error">{error}</Alert>

      <div className={styles.quiz}>
        <LergeDarkBoldText>
          <div className={styles.question}>
            <QuestionIcon />
            {data.data.question}
          </div>
        </LergeDarkBoldText>

        <form
          onSubmit={answerForm.handleSubmit(handleAnswer)}
          className={styles.answerForm}
        >
          <AnswerIcon />
          <InputMediumGrayTextArea
            name="message"
            placeholder="英文を入力してください。"
            register={answerForm.register}
            validation={{
              required: "答えは必須項目です",
              maxLength: {
                value: 2048,
                message: "有効な答えを入力してください。",
              },
            }}
            disabled={dontNeedsAnswer() || isSending}
          >
            {data?.data.response?.response}
          </InputMediumGrayTextArea>
          <div className={styles.answerFormSubmitButton}>
            <GreenButton
              disabled={
                !answerForm.formState.isValid || isSending || dontNeedsAnswer()
              }
              type="submit"
            >
              <FontAwesomeIcon size="2x" icon={faPaperPlane} />
            </GreenButton>
          </div>
        </form>
        {answerForm.formState.errors.message ? (
          <ValidationError
            error={answerForm.formState.errors.message.message}
          />
        ) : (
          <></>
        )}
      </div>

      <div className={styles.messageList}>
        {dontNeedsAnswer() ? (
          data.data.response?.replyList.map((reply) => {
            if (reply.role === "assistant") {
              return (
                <div
                  key={reply.quizResponseReplyId}
                  className={styles.messageOfBot}
                >
                  <ChatMessage
                    message={reply.message}
                    icon={"/images/robot.png"}
                  />
                </div>
              );
            }

            return (
              <div
                key={reply.quizResponseReplyId}
                className={styles.messageOfMe}
              >
                <ChatMessage message={reply.message} icon={user?.icon!} />
              </div>
            );
          })
        ) : (
          <></>
        )}
      </div>

      {dontNeedsAnswer() ? (
        <>
          <form
            onSubmit={chatForm.handleSubmit(handleAnswer)}
            className={styles.chatForm}
          >
            <InputMediumGrayTextArea
              name="message"
              placeholder="質問を入力してください。"
              register={chatForm.register}
              validation={{
                required: "答えは必須項目です",
                maxLength: {
                  value: 2048,
                  message: "有効な答えを入力してください。",
                },
              }}
              disabled={needsAnswer() || isSending}
            />
            <div className={styles.chatFormSubmitButton}>
              <GreenButton
                disabled={
                  !chatForm.formState.isValid || isSending || needsAnswer()
                }
                type="submit"
              >
                <FontAwesomeIcon size="2x" icon={faPaperPlane} />
              </GreenButton>
            </div>
          </form>
          {chatForm.formState.errors.message ? (
            <ValidationError
              error={chatForm.formState.errors.message.message}
            />
          ) : (
            <></>
          )}
        </>
      ) : (
        <></>
      )}
    </div>
  );
};
