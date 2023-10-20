const StartChat = ({ data }) => {
  return (
    <div className="chat chat-start">
      <div className="chat-image avatar">
        <div className="w-10 rounded-full">
          <img src="pp/bill.jpeg" />
        </div>
      </div>
      <div className="chat-header">
        <p>{data.username}</p>
      </div>
      <div className="chat-bubble">{data.message}</div>
      <time className="chat-footer opacity-50">12h35</time>
    </div>
  );
};
export default StartChat;
