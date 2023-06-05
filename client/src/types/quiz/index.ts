export type QuizCategory = {
  quizCategoryId: number;
  name: string;
  formalName: string;
};

type Role = "assistant" | "user";

export type QuizResponseReply = {
  role: Role;
  message: string;
  quizResponseReplyId: number;
  sendedAt: string;
};

export type QuizResponse = {
  isCorrect: boolean;
  response: string;
  replyList: QuizResponseReply[];
};

export type Quiz = {
  quizId: number;
  question: string;
  answer: string;
  category: QuizCategory;
  response?: QuizResponse;
};
